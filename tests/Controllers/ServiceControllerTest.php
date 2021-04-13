<?php
/*
 * MdNotesCCGLib
 *
 * 
 */

namespace MdNotesCCGLib\Tests;

use MdNotesCCGLib\Exceptions\ApiException;
use MdNotesCCGLib\Exceptions;
use MdNotesCCGLib\ApiHelper;
use MdNotesCCGLib\Models;
use PHPUnit\Framework\TestCase;

class ServiceControllerTest extends TestCase
{
    /**
     * @var \MdNotesCCGLib\Controllers\ServiceController Controller instance
     */
    protected static $controller;

    /**
     * @var HttpCallBackCatcher Callback
     */
    protected static $httpResponse;

    /**
     * Setup test class
     */
    public static function setUpBeforeClass(): void
    {
        $config = ClientFactory::create();
        self::$httpResponse = new HttpCallBackCatcher();
        self::$controller = $config->getServiceController(self::$httpResponse);
    }


    /**
     * Todo Add description for test testCheckServiceStatus
     */
    public function testCheckServiceStatus()
    {

        // Set callback and perform API call
        $result = null;
        
        print('--------------------------Start ');
        try {
            $result = self::$controller->getStatus();
        } catch (ApiException $e) {
            print('--------------------Exception----> '.$e->getMessage());
        }

        // Test response code
        $this->assertEquals(
            200,
            self::$httpResponse->getResponse()->getStatusCode(),
            "Status is not 200"
        );
    }
}
