<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // ─────────────────────────────────────────
    //  REGISTER
    // ─────────────────────────────────────────
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        // Create user (unverified by default - email_verified_at will be null)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Send OTP for verification
        $this->sendOtp($user->email, 'verification');

        return $this->success([
            'email' => $user->email,
        ], 'Registration successful! Please verify the OTP sent to your email.');
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp'   => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        $otpRecord = Otp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$otpRecord || !$otpRecord->isValid()) {
            return $this->error('Invalid or expired OTP', 401);
        }

        $otpRecord->update(['is_used' => true]);

        $user = User::where('email', $request->email)->firstOrFail();
        
        // Mark user as verified
        $user->forceFill(['email_verified_at' => now()])->save();

        $token = JWTAuth::fromUser($user);

        return $this->success([
            'user'       => $user,
            'token'      => $token,
            'token_type' => 'bearer',
        ], 'Account verified and logged in successfully');
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error('Invalid credentials', 401);
        }

        // Check if user is verified
        if (!$user->email_verified_at) {
            $this->sendOtp($user->email, 'verification');
            return $this->error('Your account is not verified. A new OTP has been sent.', 403);
        }

        $token = JWTAuth::fromUser($user);

        return $this->success([
            'user'       => $user,
            'token'      => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
        ], 'Login successful');
    }

    // ─────────────────────────────────────────
    //  LOGOUT
    // ─────────────────────────────────────────
    public function logout(Request $request): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return $this->success(null, 'Logged out successfully');
        } catch (JWTException $e) {
            return $this->error('Could not logout', 500);
        }
    }

    // ─────────────────────────────────────────
    //  REFRESH TOKEN
    // ─────────────────────────────────────────
    public function refresh(): JsonResponse
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());

            return $this->success([
                'token'      => $newToken,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60,
            ], 'Token refreshed');
        } catch (JWTException $e) {
            return $this->error('Token cannot be refreshed', 401);
        }
    }

    // ─────────────────────────────────────────
    //  ME (authenticated user info)
    // ─────────────────────────────────────────
    public function me(): JsonResponse
    {
        return $this->success(auth('api')->user(), 'User info');
    }

    // ─────────────────────────────────────────
    //  FORGOT PASSWORD – send OTP
    // ─────────────────────────────────────────
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        $this->sendOtp($request->email, 'password_reset');

        return $this->success(null, 'Password reset OTP sent to your email.');
    }

    // ─────────────────────────────────────────
    //  VERIFY RESET OTP
    // ─────────────────────────────────────────
    public function verifyResetOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp'   => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        $otpRecord = Otp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('type', 'password_reset')
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$otpRecord || !$otpRecord->isValid()) {
            return $this->error('Invalid or expired OTP', 401);
        }

        // Mark as used on actual reset, return a short-lived reset token
        return $this->success([
            'reset_token' => encrypt($request->email . '|' . $request->otp),
        ], 'OTP verified. Proceed to reset password.');
    }

    // ─────────────────────────────────────────
    //  RESET PASSWORD
    // ─────────────────────────────────────────
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'reset_token'           => 'required|string',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        try {
            [$email, $otp] = explode('|', decrypt($request->reset_token));
        } catch (\Exception) {
            return $this->error('Invalid reset token', 400);
        }

        $otpRecord = Otp::where('email', $email)
            ->where('otp', $otp)
            ->where('type', 'password_reset')
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$otpRecord || !$otpRecord->isValid()) {
            return $this->error('Reset token has expired. Please request a new OTP.', 401);
        }

        $user = User::where('email', $email)->firstOrFail();
        $user->update(['password' => Hash::make($request->password)]);
        $otpRecord->update(['is_used' => true]);

        return $this->success(null, 'Password reset successfully. Please login.');
    }

    // ─────────────────────────────────────────
    //  HELPERS
    // ─────────────────────────────────────────
    private function sendOtp(string $email, string $type): void
    {
        // Invalidate old OTPs
        Otp::where('email', $email)->where('type', $type)->update(['is_used' => true]);

        $otp = Otp::generateOtp();

        Otp::create([
            'email'      => $email,
            'otp'        => $otp,
            'type'       => $type,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send actual email
        try {
            Mail::to($email)->send(new OtpMail($otp, $type));
        } catch (\Exception $e) {
            \Log::error("Mail failed: " . $e->getMessage());
        }

        // Keep log for backup/debugging
        \Log::info("OTP for {$email} [{$type}]: {$otp}");
    }

    private function success(mixed $data, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    private function error(mixed $message, int $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => null,
        ], $code);
    }
}
