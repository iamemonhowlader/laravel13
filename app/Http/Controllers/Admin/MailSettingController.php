<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MailSettingController extends Controller
{
    public function index()
    {
        $settings = [
            'MAIL_MAILER'       => env('MAIL_MAILER'),
            'MAIL_HOST'         => env('MAIL_HOST'),
            'MAIL_PORT'         => env('MAIL_PORT'),
            'MAIL_USERNAME'     => env('MAIL_USERNAME'),
            'MAIL_PASSWORD'     => env('MAIL_PASSWORD'),
            'MAIL_ENCRYPTION'   => env('MAIL_ENCRYPTION'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
            'MAIL_FROM_NAME'    => env('MAIL_FROM_NAME'),
        ];

        return view('backend.layouts.settings.mail', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'MAIL_MAILER'       => 'required|string',
            'MAIL_HOST'         => 'required|string',
            'MAIL_PORT'         => 'required|string',
            'MAIL_USERNAME'     => 'nullable|string',
            'MAIL_PASSWORD'     => 'nullable|string',
            'MAIL_ENCRYPTION'   => 'nullable|string',
            'MAIL_FROM_ADDRESS' => 'required|email',
            'MAIL_FROM_NAME'    => 'required|string',
        ]);

        foreach ($data as $key => $value) {
            $this->updateDotEnv($key, $value);
        }

        return back()->with('success', 'Mail settings updated successfully!');
    }

    private function updateDotEnv($key, $value)
    {
        $path = base_path('.env');

        if (File::exists($path)) {
            $content = File::get($path);
            
            // Handle values with spaces by wrapping in quotes
            if (strpos($value, ' ') !== false && strpos($value, '"') === false) {
                $value = '"' . $value . '"';
            }

            $oldLine = $key . '=' . env($key);
            $newLine = $key . '=' . $value;

            if (strpos($content, $key . '=') !== false) {
                // Key exists, replace it
                $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
            } else {
                // Key doesn't exist, append it
                $content .= "\n{$key}={$value}";
            }

            File::put($path, $content);
        }
    }
}
