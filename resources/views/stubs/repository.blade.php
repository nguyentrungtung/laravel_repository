@php
    echo '<'. '?php';
@endphp


namespace {{$name_space}};

use {{$contract_path}};
use {{$model_path}};

class {{$class_name}}{{$use_abstract ? " extends $abstract_repo_name " : ' '}}implements {{$contract_name}}
{

    protected $querySearchTargets = [
        'name'
    ];

    public function getBlankModel()
    {
        return new {{$model_name}}();
    }
}
