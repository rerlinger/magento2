<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\NewRelicReporting\Test\Unit\Model\Observer;

use Magento\NewRelicReporting\Model\Observer\ReportConcurrentAdmins;

/**
 * Class ReportConcurrentAdminsTest
 */
class ReportConcurrentAdminsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ReportConcurrentAdmins
     */
    protected $model;

    /**
     * @var \Magento\NewRelicReporting\Model\Config|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $config;

    /**
     * @var \Magento\Backend\Model\Auth\Session|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $backendAuthSession;

    /**
     * @var \Magento\NewRelicReporting\Model\UsersFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $usersFactory;

    /**
     * @var \Magento\NewRelicReporting\Model\Users|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $usersModel;

    /**
     * @var \Magento\Framework\Json\EncoderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $jsonEncoder;

    /**
     * @var \Magento\Framework\Stdlib\DateTime|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $dateTime;

    /**
     * Setup
     * 
     * @return void
     */
    public function setUp()
    {
        $this->config = $this->getMockBuilder('Magento\NewRelicReporting\Model\Config')
            ->disableOriginalConstructor()
            ->setMethods(['isNewRelicEnabled'])
            ->getMock();
        $this->backendAuthSession = $this->getMockBuilder('Magento\Backend\Model\Auth\Session')
            ->disableOriginalConstructor()
            ->setMethods(['isLoggedIn', 'getUser'])
            ->getMock();
        $this->usersFactory = $this->getMockBuilder('Magento\NewRelicReporting\Model\UsersFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $this->usersModel = $this->getMockBuilder('Magento\NewRelicReporting\Model\Users')
            ->disableOriginalConstructor()
            ->getMock();
        $this->jsonEncoder = $this->getMockBuilder('Magento\Framework\Json\EncoderInterface')
            ->getMock();
        $this->dateTime = $this->getMockBuilder('Magento\Framework\Stdlib\DateTime')
            ->disableOriginalConstructor()
            ->setMethods(['formatDate'])
            ->getMock();

        $this->usersFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->usersModel);

        $this->model = new ReportConcurrentAdmins(
            $this->config,
            $this->backendAuthSession,
            $this->usersFactory,
            $this->jsonEncoder,
            $this->dateTime
        );
    }

    /**
     * Test case when module is disabled in config
     *
     * @return void
     */
    public function testReportConcurrentAdminsModuleDisabledFromConfig()
    {
        $this->config->expects($this->once())
            ->method('isNewRelicEnabled')
            ->willReturn(false);

        $this->assertSame(
            $this->model,
            $this->model->execute()
        );
    }

    /**
     * Test case when user is not logged in
     *
     * @return void
     */
    public function testReportConcurrentAdminsUserIsNotLoggedIn()
    {
        $this->config->expects($this->once())
            ->method('isNewRelicEnabled')
            ->willReturn(true);
        $this->backendAuthSession->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(false);

        $this->assertSame(
            $this->model,
            $this->model->execute()
        );
    }

    /**
     * Test case when module is enabled and user is logged in 
     *
     * @return void
     */
    public function testReportConcurrentAdmins()
    {
        $testAction = 'JSON string';
        $testUpdated = '1970-01-01 00:00:00';

        $this->config->expects($this->once())
            ->method('isNewRelicEnabled')
            ->willReturn(true);
        $this->backendAuthSession->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(true);
        $userMock = $this->getMockBuilder('Magento\User\Model\User')->disableOriginalConstructor()->getMock();
        $this->backendAuthSession->expects($this->once())
            ->method('getUser')
            ->willReturn($userMock);
        $this->jsonEncoder->expects($this->once())
            ->method('encode')
            ->willReturn($testAction);
        $this->dateTime->expects($this->once())
            ->method('formatDate')
            ->willReturn($testUpdated);
        $this->usersModel->expects($this->once())
            ->method('setData')
            ->with(['type' => 'admin_activity', 'action' => $testAction, 'updated_at' => $testUpdated])
            ->willReturnSelf();
        $this->usersModel->expects($this->once())
            ->method('save');

        $this->assertSame(
            $this->model,
            $this->model->execute()
        );
    }
}
