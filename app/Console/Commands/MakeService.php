<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Generate a Service and Interface, and bind them in AppServiceProvider';

    public function handle()
    {
        $name = $this->argument('name');
        $serviceName = "{$name}Service";
        $interfaceName = "{$name}ServiceInterface";

        $servicePath = app_path("Services/{$serviceName}.php");
        $interfacePath = app_path("Services/{$interfaceName}.php");

        // 1. Buat folder jika belum ada
        if (!File::exists(app_path('Services'))) {
            File::makeDirectory(app_path('Services'), 0755, true);
        }

        // 2. Generate Interface
        $interfaceContent = "<?php

namespace App\Services\Contracts;

interface {$interfaceName}
{
    //
}
";
        File::put($interfacePath, $interfaceContent);

        // 3. Generate Service
        $serviceContent = "<?php

namespace App\Services;

use App\Services\\{$interfaceName};

class {$serviceName} implements {$interfaceName}
{
    //
}
";
        File::put($servicePath, $serviceContent);

        // 4. Tambah binding di AppServiceProvider
        $providerPath = app_path('Providers/AppServiceProvider.php');
        $providerContent = File::get($providerPath);

        $bindingLine = "\$this->app->bind(\App\Services\\{$interfaceName}::class, \App\Services\\{$serviceName}::class);";

        if (!str_contains($providerContent, $bindingLine)) {
            $providerContent = str_replace(
                'public function register()',
                "public function register()\n    {\n        {$bindingLine}",
                $providerContent
            );

            File::put($providerPath, $providerContent);
        }

        $this->info("Service {$serviceName} and Interface {$interfaceName} created and bound successfully.");
    }
}
