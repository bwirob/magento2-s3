<?php

namespace Thai\S3\Test\Plugin;

use Magento\MediaStorage\Model\Config\Source\Storage\Media\Storage;
use PHPUnit\Framework\TestCase;
use Thai\S3\Plugin\AddS3ToMediaStorageOptions;

class AddS3ToMediaStorageOptionsTest extends TestCase
{
    /**
     * @var AddS3ToMediaStorageOptions
     */
    protected $_object;

    /**
     * @var Storage
     */
    protected $_storage;

    protected function setUp()
    {
        $this->_storage = $this->createMock(Storage::class);
        $this->_object = new AddS3ToMediaStorageOptions();
    }

    public function testAmazonS3IsAddedToMediaStorageOptions()
    {
        $this->assertContains(
            [
                'value' => \Thai\S3\Model\MediaStorage\File\Storage::STORAGE_MEDIA_S3,
                'label' => __('Amazon S3'),
            ],
            $this->_object->afterToOptionArray($this->_storage, [])
        );
    }
}
