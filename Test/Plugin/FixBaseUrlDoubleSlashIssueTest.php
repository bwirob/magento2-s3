<?php
namespace Thai\S3\Test\Plugin;

use Magento\Store\Model\Store;
use PHPUnit\Framework\TestCase;
use Thai\S3\Plugin\FixBaseUrlDoubleSlashIssue;

class FixBaseUrlDoubleSlashIssueTest extends TestCase
{
    /**
     * @var Store
     */
    protected $_store;

    /**
     * @var FixBaseUrlDoubleSlashIssue
     */
    protected $_object;

    protected function setUp()
    {
        $this->_store = $this->createMock(Store::class);
        $this->_object = new FixBaseUrlDoubleSlashIssue();
    }

    public function testDoubleSlashIsReplacedWithSingleSlash()
    {
        $this->assertEquals($this->_object->afterGetBaseUrl($this->_store, "//get.php/"), "/get.php/");
    }
}
