<?php
namespace Thai\S3\Plugin;

use Magento\Store\Model\Store;

/**
 * Plugin for Store.
 *
 * @see Store
 */
class FixBaseUrlDoubleSlashIssue
{
    /**
     * This plugin fixes a bug where Magento incorrectly appends two forward
     * slashes to the media rewrite script. We remove one of those extra forward
     * slashes.
     *
     * @param Store $subject
     * @param string $result
     * @return string
     */
    public function afterGetBaseUrl(Store $subject, $result)
    {
        return str_replace('//get.php/', '/get.php/', $result);
    }
}
