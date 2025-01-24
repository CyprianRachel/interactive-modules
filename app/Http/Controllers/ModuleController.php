<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use ZipArchive;

class ModuleController extends Controller
{
    // POST /modules
    public function store(Request $request)
    {
        $validated = $request->validate([
            'width'  => 'required|integer|min:1',
            'height' => 'required|integer|min:1',
            'color'  => 'required|string',
            'link'   => 'required|url',
        ]);

        $module = Module::create($validated);

        return response()->json([
            'id' => $module->id
        ], 201);
    }

    // GET /modules/{id}/download
    public function download($id)
    {
        $module = Module::findOrFail($id);

        // Generowanie zawartości poszczególnych plików
        $htmlContent = $this->generateHtml($module);
        $cssContent  = $this->generateCss($module);
        $jsContent   = $this->generateJs($module);

        // Tworzenie ZIP
        $zipFileName = 'module_' . $module->id . '.zip';
        $zip = new ZipArchive();
        $zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFromString('index.html', $htmlContent);
        $zip->addFromString('styles.css', $cssContent);
        $zip->addFromString('script.js', $jsContent);
        $zip->close();

        // ZIP do pobrania usuwany po wysłaniu
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }

    private function generateHtml(Module $module)
    {
        return <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Module {$module->id}</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <div id="my-module">
                Kliknij mnie, aby przejść do: {$module->link}
            </div>
            <script src="script.js"></script>
        </body>
        </html>
        HTML;
    }

    private function generateCss(Module $module)
    {
        // Ustawienie szerokości, wysokości, koloru tła
        return <<<CSS
        #my-module {
            width: {$module->width}px;
            height: {$module->height}px;
            background-color: {$module->color};
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #fff;
        }
        CSS;
    }

    private function generateJs(Module $module)
    {
        /* Otwiera link w nowej karcie */
        return <<<JS
        document.addEventListener('DOMContentLoaded', function() {
            var moduleDiv = document.getElementById('my-module');
            moduleDiv.addEventListener('click', function() {
                window.open('{$module->link}', '_blank');
            });
        });
        JS;
    }
}
