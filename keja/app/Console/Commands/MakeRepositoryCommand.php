<?php
/**
 * Created by Philip Njuguna.
 * User: Philip Njuguna
 * Date: 11/13/18
 * Time: 5:19 PM
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\InputArgument;

class MakeRepositoryCommand extends Command
{

    protected $signature = 'make:repository {repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new repository.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $parameter = $this->arguments()['repository'];

        $structure = (explode('/',$parameter));

        $length = count($structure);


        //create directories
        $dir  = '/Innox/Classes/Repository';
        $namespace  = 'Innox \Classes\Repository';


        for ($i=0; $i < $length-1; $i++)
        {
            $dir = $dir.'/'.$structure[$i];
            $namespace = $namespace.'\\'.$structure[$i];
            if(! is_dir(base_path().$dir))
            {
                mkdir(base_path().$dir);
            }
        }


        $class = $structure[$length-1];


        $fileContent = "";
        $fileContent.="<?php \n\n";
        $fileContent.="\nnamespace ".$namespace.";";
        $fileContent.="\nuse Illuminate\Http\Request;";
        $fileContent.="\n\nClass ".$class;
        $fileContent.="\n{";
        $fileContent.="\n";
        $fileContent.="\n\t/**\n\t*param Request \$request*/\n\t** @param Request \$request*/";
        $fileContent.="\n\tpublic function all(Request \$request)";
        $fileContent.="\n\t{";
        $fileContent.="\n";
        $fileContent.="\n\t// TODO: Implement all() method.";
        $fileContent.="\n\t}";
        $fileContent.="\n";
        $fileContent.="";
        $fileContent.="\n\tpublic function store(Request \$request)";
        $fileContent.="\n\t{";
        $fileContent.="\n";
        $fileContent.="\n\t// TODO: Implement store() method.";
        $fileContent.="\n\t}";
        $fileContent.="";
        $fileContent.="\n\tpublic function update(Request \$request)";
        $fileContent.="\n\t{";
        $fileContent.="\n";
        $fileContent.="\n\t// TODO: Implement update() method.";
        $fileContent.="\n\t}";
        $fileContent.="";
        $fileContent.="\n\tpublic function delete(Request \$request)";
        $fileContent.="\n\t{";
        $fileContent.="\n";
        $fileContent.="\n\t// TODO: Implement delete() method.";
        $fileContent.="\n\t}";
        $fileContent.="\n} ";


        //if file already exist don't create overwrite.
        if(file_exists(base_path().$dir.'/'.$class.'.php')){
            $this->info('class '.$class.' already exists!');
            return;
        }


        $fp = fopen(base_path().$dir.'/'.$class.'.php','w');
        fwrite($fp,$fileContent);
        fclose($fp);


        $this->info('Successfully created '.$class);

    }

    protected function getOptions()
    {
        return parent::getOptions();
    }
    protected function getArguments()
    {
        return array(
            array('serviceName',InputArgument::REQUIRED,'The name of the service class.'),
        );
    }
}
