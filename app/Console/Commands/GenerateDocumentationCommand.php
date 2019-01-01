<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/30/18
 * Time: 9:42 PM
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GenerateDocumentationCommand extends Command
{
    /**
     * @var array
     */
    protected $config;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "apidocs {--vrbs : Verbose of apidoc}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generate API Blueprint Documentation.";

    public function __construct()
    {
        parent::__construct();

        $this->config = [
            'url' => 'docs',
            'output' => 'public/',
            'documentFilePath' => resource_path('documentation/'),
            'headerTemplateContent' => file_get_contents(resource_path('documentation/shared/header.template.md')),
        ];
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->info('Generating API Blueprint Documentation ...');

        $path = $this->config['output'] . $this->config['url'] . '/generated-markdown';
        if (!file_exists($path)) {
            app('files')->makeDirectory($path, $mode = 0777, true, true);
        }

        $this->generateHeader($path, '/header.md');
        $this->generateAPIDocsTask();

        app('files')->deleteDirectory($path);
        $this->info("\n" . 'Done! visit url > ' . config('app.url') . '/' . $this->config['url']);
    }

    private function generateHeader($path, $fileName)
    {
        $replacer = function ($templateKey, $value) {
            $this->config['headerTemplateContent'] =
                str_replace($templateKey, $value, $this->config['headerTemplateContent']);
        };

        $apiConfig = config('api');

        $replacer('{{api.domain.dev}}', config('app.url'));
        $replacer('{{accept-header}}',
            "application/{$apiConfig['standardsTree']}.{$apiConfig['subtype']}.{$apiConfig['version']}+json");
        $replacer('{{rate-limit-expires}}', config('setting.api.throttle.expires'));
        $replacer('{{rate-limit-attempts}}', config('setting.api.throttle.limit'));
        $replacer('{{access-token-expires}}', config('setting.api.token.access_token_expire'));
        $replacer('{{refresh-token-expires}}', config('setting.api.token.refresh_token_expire'));
        $replacer('{{pagination-limit}}', config('repository.pagination.limit'));

        file_put_contents(base_path($path . $fileName), $this->config['headerTemplateContent']);
    }


    private function generateAPIDocsTask()
    {
        $path = $this->config['output'] . $this->config['url'];

        $inputs = '--input app/Http/Controllers';
        $inputs .= ' --input resources/documentation/responses';

        $verbose = ' --silent';
        if ($this->option('vrbs') == true) {
            $verbose = ' --verbose';
        }

        $command = "apidoc --config {$this->getJsonConfigurationPath()} $inputs --output $path{$verbose}";

        $this->comment("Executing command: [$command]");
        $process = new Process($command);
        // execute the command
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

//        $this->info('Result: ' . $process->getOutput());
    }

    private function getJsonConfigurationPath()
    {
        $template = str_replace(base_path(), '', $this->config['documentFilePath']);
        return substr($template, 1, strlen($template) - 1);
    }
}