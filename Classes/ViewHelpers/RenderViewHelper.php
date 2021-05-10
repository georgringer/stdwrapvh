<?php
declare(strict_types=1);

namespace GeorgRinger\Stdwrapvh\ViewHelpers;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;


class RenderViewHelper extends AbstractViewHelper
{

    /** @var bool */
    protected $escapeOutput = false;

    /** @var array */
    static protected $renderedRecords = [];

    public function initializeArguments()
    {
        $this->registerArgument('table', 'string', '', true);
        $this->registerArgument('fields', 'string', '', true);
        $this->registerArgument('id', 'int', '', true);
        $this->registerArgument('mode', 'string', '', true);
        $this->registerArgument('configuration', 'array', '', false, []);
    }

    public function render()
    {
        $table = $this->arguments['table'];
        $fields = $this->arguments['fields'];
        $id = $this->arguments['id'];
        $configuration = $this->arguments['configuration'];
        $content = $this->renderChildren();

        $enabled = true;

        switch ($this->arguments['mode']) {
            case 'editIcon':
                $enabled = $this->backendUserAvailable();
                $configuration['editIcons'] = $table . ':' . $fields;
                break;
            case 'editPanel':
                $enabled = $this->backendUserAvailable();
                $configuration2 = [
                    'editPanel' => 1,
                    'editPanel.' => [
                        'allow' => 'edit', // , new, delete 	41
                        'fieldList' => 'title',
                        'line' => 5,
                        'label' => '%s',
                        'previewBorder' => 4
                    ]
                ];
                $configuration = array_merge_recursive($configuration2, $configuration);
                break;
        }

        if ($enabled) {
            $key = $table . '_' . $id;
            if (!isset(self::$renderedRecords[$key])) {
                $record = BackendUtility::getRecord($table, $id);
                self::$renderedRecords[$key] = $record;
            }

            $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
            $cObj->start(self::$renderedRecords[$key], $table);

            $content = $cObj->stdWrap($content, $configuration);
        }

        return $content;
    }

    protected function backendUserAvailable(): bool
    {
        $status = false;
        if (isset($GLOBALS['BE_USER']) && is_object($GLOBALS['BE_USER'])) {
            $status = true;
        }

        return $status;
    }

}
