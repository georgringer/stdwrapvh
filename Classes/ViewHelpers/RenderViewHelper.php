<?php

namespace GeorgRinger\Stdwrapvh\ViewHelpers;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Georg Ringer <typo3@ringerge.org>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

class RenderViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var array
	 */
	static protected $renderedRecords = array();

	/**
	 * @param string $table
	 * @param string $fields
	 * @param int $id
	 * @param array $configuration
	 * @param string $mode
	 * @return string
	 */
	public function render($table, $fields, $id, $configuration = array(), $mode = '') {
		$content = $this->renderChildren();

		$enabled = TRUE;

		switch ($mode) {
			case 'editIcon':
				$enabled = $this->backendUserAvailable();
				$configuration['editIcons'] = $table . ':' . $fields;
				break;
			case 'editPanel':
				$enabled = $this->backendUserAvailable();
				$configuration2 = array(
					'editPanel' => 1,
					'editPanel.' => array(
						'allow' => 'edit', // , new, delete 	41
						'fieldList' => 'title',
						'line' => 5,
						'label' => '%s',
						'previewBorder' => 4
					)
				);
				$configuration = array_merge_recursive($configuration2, $configuration);
				break;
		}

		if ($enabled) {
			$key = $table . '_' . $id;
			if (!isset(self::$renderedRecords[$key])) {
				$record = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('*', $table, 'uid=' . (int)$id);
				self::$renderedRecords[$key] = $record;
			}

			$cObj = GeneralUtility::makeInstance('tslib_cObj');
			$cObj->start(self::$renderedRecords[$key], $table);

			$content = $cObj->stdWrap($content, $configuration);
		}

		return $content;
	}

	/**
	 * @return bool
	 */
	protected function backendUserAvailable() {
		$status = FALSE;
		if (isset($GLOBALS['BE_USER']) && is_object($GLOBALS['BE_USER'])) {
			$status = TRUE;
		}

		return $status;
	}

}