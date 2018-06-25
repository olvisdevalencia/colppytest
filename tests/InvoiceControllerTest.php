<?php

use App\DetalleFacturas;
use App\Http\Controllers\InvoicesController;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InvoiceControllerTest extends TestCase
{

  public $invoice;
  /**
   * @var FakerGenerator
   */
  protected $faker;

  /*
   *  Instanciate full InvoicesController and faker helper
   */
  public function setUp()
  {
      parent::setUp();
      $this->invoice = new InvoicesController();
      $this->faker = \Faker\Factory::create();
  }

  /*
   *  Test method to check a list of invoices if empty or full json list
   *  Success test
   */
  public function testGetList()
  {
      $request = request();
      $list = $this->invoice->getList($request);

      $data = json_decode($list->getContent(), true);

      $this->seeJsonStructure([
                       '*' => [
                         'id',
                         'empresa',
                         'cliente',
                         'Subtotal',
                         'IVA',
                         'total',
                         'created_at'
                       ]
                   ], $data);

      $this->assertEquals(200, $list->status());

      $this->assertTrue(true);
  }

  /*
   *  Test method to check if an invoice has been success created
   *  Success test
   */
  public function testSuccessPostCreate() {

    $request      = request();

    for ($i=0; $i < 5; $i++) {
      $detailList[] = [
        "name"   => $this->faker->lexify('Producto test unitario ???'),
        "qty"    => $this->faker->numberBetween(4,10),
        "amount" => $this->faker->numberBetween(300,800)
      ];
    }
    $request->idEmpresa   = 1;
    $request->idCliente   = random_int(1,2);
    $request->detailList  = $detailList;

    $invoice_create = $this->invoice->postCreate($request);

    $data = json_decode($invoice_create->getContent(), true);

    $this->seeJsonStructure([
                       'success'
                 ], $data);

    $this->assertEquals(200, $invoice_create->status());

    $this->assertTrue($data['success']);
  }

  /*
   *  Test method to check if an invoice has been fail
   *  Failed test
   */
  public function testFailedPostCreate() {

    $request = request();
    $request->idEmpresa   = 1;
    $request->idCliente   = random_int(1,2);
    $invoice_create = $this->invoice->postCreate($request);

    $data = json_decode($invoice_create->getContent(), true);

    $this->seeJsonStructure([
                       'success'
                 ], $data);

    $this->assertEquals(200, $invoice_create->status());

    $this->assertFalse($data['success']);
  }

  /*
   *  Test method to check if an invoice exist and return invoice data
   *  Success test
   */
  public function testSuccessGetInvoiceById() {

    $request = request();
    $request->idFactura   = random_int(1,2);
    $invoice_view = $this->invoice->getInvoiceById($request);

    $data = json_decode($invoice_view->getContent(), true);

    $this->seeJsonStructure([
                       'empresa',
                       'cliente',
                       'factura',
                       'detalles',
                       'success'
                 ], $data);

    $this->assertEquals(200, $invoice_view->status());

    $this->assertTrue($data['success']);
  }


  /*
   *  Test method to check if an invoice exist and return invoice data
   *  Failed test
   */
  public function testFailedGetInvoiceById() {

    $request = request();
    $request->idFactura   = random_int(1,2);
    $invoice_view = $this->invoice->postCreate($request);

    $data = json_decode($invoice_view->getContent(), true);

    $this->seeJsonStructure([
                       'success'
                 ], $data);

    $this->assertEquals(200, $invoice_view->status());

    $this->assertFalse($data['success']);
  }


  /*
   *  Test method to check if an invoice has been success edited
   *  Success test
   */
  public function testSuccessEditInvoiceById() {

    $request      = request();

    for ($i=0; $i < 5; $i++) {
      $newestList[] = [
        "nombreItem"      => $this->faker->lexify('Producto test edit unitario ???'),
        "cantidad"        => $this->faker->numberBetween(1,3),
        "precio_unitario" => $this->faker->numberBetween(300,800)
      ];
    }
    $random_invoice_id       = random_int(1,3);
    $request->invoiceId      = $random_invoice_id;
    $request->enterpriseId   = 1;
    $request->newestList     = $newestList;
    $request->oldestList     = DetalleFacturas::where('idFactura', $random_invoice_id)->get();
    $request->deleteList     = null;

    $invoice_edit = $this->invoice->editInvoiceById($request);

    $data = json_decode($invoice_edit->getContent(), true);

    $this->seeJsonStructure([
                       'success'
                 ], $data);

    $this->assertEquals(200, $invoice_edit->status());

    $this->assertTrue($data['success']);
  }

  /*
   *  Test method to check if an invoice has been success edited
   *  Failed test
   */
  public function testFailedEditInvoiceById() {

    $request      = request();

    for ($i=0; $i < 5; $i++) {
      $newestList[] = [
        "nombreItem"      => $this->faker->lexify('Producto test edit unitario ???'),
        "cantidad"        => $this->faker->numberBetween(1,3),
        "precio_unitario" => $this->faker->numberBetween(300,800)
      ];
    }
    $random_invoice_id       = random_int(1,3);
    $request->invoiceId      = $random_invoice_id;
    $request->enterpriseId   = 1;
    $request->newestList     = $newestList;
    $request->oldestList     = null;
    $request->deleteList     = null;

    $invoice_edit = $this->invoice->editInvoiceById($request);

    $data = json_decode($invoice_edit->getContent(), true);

    $this->seeJsonStructure([
                       'success'
                 ], $data);

    $this->assertEquals(200, $invoice_edit->status());

    $this->assertFalse($data['success']);
  }


  public function tearDown()
  {
      parent::tearDown();
      $this->invoice = null;
  }
}
