<?php

namespace Kathore\LaraFormik\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class InstallLaraFormik extends Command
{
    protected $signature = 'lara-formik:publish';
    protected $description = 'Install and configure LaraFormik package';

    public function handle()
    {
        $this->info("Running LaraFormik package configure installation...");
        // Call the static method to run installation steps
        $this->addNotification();
        $this->runCmd();
        $this->addCustomCss();
        $this->addRoutes();
        $this->info("LaraFormik package configure installed successfully.");
    }

    protected function runCmd()
    {
        // Run only when in console environment
        Artisan::call('vendor:publish', [
            '--tag' => 'lara-formik',
            '--force' => true
        ]);
        // Run npm install command
        $output = null;
        $resultCode = null;
        // Ensure you run it in the correct directory
        exec('cd ' . base_path() . ' && npm install @headlessui/vue@1.7.23 @heroicons/vue@2.1.5 @mayasabha/ckeditor4-vue3@1.0.8 @vueform/multiselect@2.6.9 swiper@8.3.2 lodash@4.17.19', $output, $resultCode);
        // Handle the result
        if ($resultCode !== 0) {
            Log::error('npm install failed: ' . implode("\n", $output));
        } else {
            Log::info('npm install successful: ' . implode("\n", $output));
        }
    }

    protected function addCustomCss()
    {
        // Path to the existing app.css file in your package
        $cssPath = resource_path('css/app.css');
        // Check if the app.css file exists
        if (File::exists($cssPath)) {

            // Define a unique marker to check if custom CSS is already appended
            $uniqueMarker = '/* Custom CSS Block - LaraFormik */';

            // Read the current contents of app.css
            $currentCss = File::get($cssPath);

            // Check if the custom CSS block is already present
            if (strpos($currentCss, $uniqueMarker) === false) {
                // If the custom CSS block is not found, append the custom CSS

                $customCss = "
@layer components {
    .primary {
        @apply text-white bg-primary hover:bg-primary-hover focus:bg-primary-focus active:bg-primary-active focus:ring-primary-focus disabled:bg-primary-disable;
    }

    .secondary {
        @apply text-dark-light bg-secondary hover:bg-secondary-hover focus:bg-secondary-focus active:bg-secondary-active focus:ring-secondary-focus disabled:bg-secondary-disable;
    }

    .success {
        @apply text-white bg-success hover:bg-success-hover focus:bg-success-focus active:bg-success-active focus:ring-success-focus disabled:bg-success-disable;
    }

    .warning {
        @apply text-white bg-warning hover:bg-warning-hover focus:bg-warning-focus active:bg-warning-active focus:ring-warning-focus disabled:bg-warning-disable;
    }

    .danger {
        @apply text-white bg-danger hover:bg-danger-hover focus:bg-danger-focus active:bg-danger-active focus:ring-danger-focus disabled:bg-danger-disable;
    }

    .info {
        @apply text-white bg-info hover:bg-info-hover focus:bg-info-focus active:bg-info-active focus:ring-info-focus disabled:bg-info-disable;
    }

    .light {
        @apply text-dark-light bg-light-light hover:bg-light-hover focus:bg-light-focus active:bg-light-active focus:ring-light-focus disabled:bg-light-disable;
    }

    .dark {
        @apply text-white bg-dark hover:bg-dark-hover focus:bg-dark-focus active:bg-dark-active focus:ring-dark-focus disabled:bg-dark-disable;
    }

    .default {
        @apply text-white bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:ring-indigo-500;
    }

     .btn {
        @apply leading-4 focus:outline-none inline-flex gap-2 items-center px-4 py-3 border border-transparent justify-center cursor-pointer rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 disabled:cursor-not-allowed;
    }

    /* Custom CSS Block - LaraFormik */ /* This is the marker to indicate the custom CSS has been added */
}
";
                // Append the custom CSS
                File::append($cssPath, $customCss);
                Log::info('Custom CSS added to app.css');
            } else {
                Log::info('Custom CSS already exists in app.css');
            }
        } else {
            // Run only when in console environment
            Artisan::call('vendor:publish', [
                '--tag' => 'lara-formik-css',
                '--force' => true
            ]);
        }
    }

    protected function addRoutes()
    {
        // Path to the existing app.css file in your package
        $webRoute = base_path('routes/web.php');
        // Check if the app.css file exists
        if (File::exists($webRoute)) {

            // Define a unique marker to check if custom CSS is already appended
            $uniqueMarker = '/* Routes - LaraFormik */';

            // Read the current contents of app.css
            $currentCss = File::get($webRoute);

            // Check if the custom CSS block is already present
            if (strpos($currentCss, $uniqueMarker) === false) {
                // If the custom CSS block is not found, append the custom CSS

                $newRoutes = " /* Routes - LaraFormik */

                Route::get('/lara-formik', [\App\Http\Controllers\LaraFormikTestController::class, 'index'])->name('lara-formik');
                Route::post('actions', \Kathore\LaraFormik\Controllers\TableController::class)
                ->name('actions');";
                // Append the custom CSS
                File::append($webRoute, $newRoutes);
                Log::info('Custom CSS added to app.css');
            } else {
                Log::info('Custom CSS already exists in app.css');
            }
        } else {
            // Run only when in console environment
            Artisan::call('vendor:publish', [
                '--tag' => 'lara-formik-css',
                '--force' => true
            ]);
        }
    }

    public function addNotification()
    {

        // Path to the HandleInertiaRequests class file
        $filePath = app_path('Http/Middleware/HandleInertiaRequests.php');

        // Check if the file exists
        if (file_exists($filePath)) {
            // Read the content of the file
            $fileContents = file_get_contents($filePath);
            $uniqueMarker = '/* notification - LaraFormik */';
            // The text to add to the 'share()' method
            if (strpos($fileContents, $uniqueMarker) === false) {
                $customText = "
                /* notification - LaraFormik */
             ...(\Kathore\LaraFormik\Notification\ToastNotification::init()),";  // The line you want to add
                // Find the position where you want to insert the new text (after the return statement in share())
                $insertPosition = strpos($fileContents, 'return [') + strlen('return [');

                if ($insertPosition !== false) {
                    // Insert the custom text at the desired position
                    $modifiedContent = substr_replace($fileContents, $customText . PHP_EOL, $insertPosition, 0);

                    // Write the modified content back to the file
                    file_put_contents($filePath, $modifiedContent);
                }
            }
        } else {
            echo "File not found!";
        }
    }
}
