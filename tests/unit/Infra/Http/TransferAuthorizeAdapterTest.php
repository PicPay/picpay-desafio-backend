<?php


namespace Transfer\Unit\Infra\Http;


use Transfer\Infra\Http\Adapter;
use Transfer\Infra\Http\Client;
use Transfer\Infra\Http\Response;
use Transfer\Infra\Http\TransferAuthorizeAdapter;
use Transfer\Stub\GuzzleClientStub;
use Transfer\Stub\ResponseInterfaceStub;
use Transfer\Stub\StreamInterfaceStub;

/**
 * Class TransferAuthorizeAdapterTest
 * @coversDefaultClass \Transfer\Infra\Http\TransferAuthorizeAdapter
 */
class TransferAuthorizeAdapterTest extends \Codeception\Test\Unit
{

    /**
     * @covers ::__construct
     * @covers ::request
     */
    public function testSuccessRequest()
    {
        $streamInterface = (new StreamInterfaceStub($this))->getDefault(json_encode(['message' => 'Autorizado']));
        $responseInterface = (new ResponseInterfaceStub($this))->with($streamInterface, 200);
        $httpClient = new Client((new GuzzleClientStub($this))->with($responseInterface));

        $adapter = new Adapter($httpClient);

        $transferAuthorizeAdapter = new TransferAuthorizeAdapter($adapter, 'https://www.fakeurl.com');
        $response = $transferAuthorizeAdapter->request();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $response->isResponseOk());
    }

}