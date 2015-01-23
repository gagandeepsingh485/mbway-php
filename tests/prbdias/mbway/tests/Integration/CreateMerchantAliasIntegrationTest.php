<?php
/*
 * This file is part of the mbway-php package.
 *
 * (c) Paulo Dias <https://github.com/prbdias/mbway-php>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace prbdias\mbway\tests\Integration;

use prbdias\mbway\Alias;
use prbdias\mbway\Alias\CreateMerchantAlias;
use prbdias\mbway\Alias\CreateMerchantAliasRequest;
use prbdias\mbway\MBWayClient;
use prbdias\mbway\Merchant;
use prbdias\mbway\MessageProperties;

class CreateMerchantAliasIntegrationTest extends IntegrationTestCase {

    /**
     * @group integration
     */
    public function testCallMerchantAliasCreation()
    {
        /* Creating the WebService main object */
        $test = new CreateMerchantAlias();
        /* Creating the WebService message object */
        $testArgument = new CreateMerchantAliasRequest();
        /* Setting the parameters */
        $testAlias = new Alias();
        $testAlias->setAliasName("351#964661733");
        $testAlias->setAliasTypeCde(Alias::$CELLPHONE);
        $testArgument->setAlias($testAlias);

        $testMerchant = new Merchant();
        $testMerchant->setIPAddress(MBWAY_CONFIG_MERCHANT_IP);
        $testMerchant->setPosId(MBWAY_CONFIG_MERCHANT_POSID);
        $testArgument->setMerchant($testMerchant);

        $testMsgProps = new MessageProperties();
        $testMsgProps->setChannel("01");
        $testMsgProps->setChannelTypeCode("VPOS");
        $testMsgProps->setNetworkCode("MULTIB");
        $merchantTimestamp = date_create("2014-09-28");
        $testMsgProps->setTimestamp($merchantTimestamp);
        $testMsgProps->setServiceType("01");
        $testMsgProps->setApiVersion("1");
        $testArgument->setMessageProperties($testMsgProps);
        $testArgument->setMessageType("N0001");

        $testNewAlias = new Alias();
        $testNewAlias->setAliasName("sara@mykubo.com");
        $testNewAlias->setAliasTypeCde(Alias::$EMAIL);
        $testArgument->setNewAlias($testNewAlias);
        $test->setArg0($testArgument);

        $service = new MBWayClient($this->getConfig());
        $response = $service->createMerchantAlias($test);
        $return = $response->getReturn();
        var_dump($return);
    }
}