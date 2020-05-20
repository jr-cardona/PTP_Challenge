<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Entities\TypeDocument;
use Illuminate\Support\Facades\Cache;

class TypeDocumentComposer
{
    /**
     * @var TypeDocument
     */
    private $typeDocuments;

    public function __construct(TypeDocument $typeDocuments)
    {
        $this->typeDocuments = $typeDocuments;
    }

    public function compose(View $view)
    {
        $view->with('typeDocuments', Cache::remember('typeDocuments.enabled', 600, function () {
            return $this->typeDocuments::all();
        }));
    }
}
