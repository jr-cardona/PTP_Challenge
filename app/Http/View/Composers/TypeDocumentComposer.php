<?php

namespace App\Http\View\Composers;

use App\TypeDocument;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TypeDocumentComposer
{
    /**
     * @var TypeDocument
     */
    private $type_documents;

    public function __construct(TypeDocument $type_documents)
    {
        $this->type_documents = $type_documents;
    }

    public function compose(View $view)
    {
        $view->with('type_documents', Cache::remember('type_documents.enabled', 600, function () {
            return $this->type_documents::all();
        }));
    }
}
