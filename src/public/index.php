<?php

declare(strict_types = 1);
require_once __DIR__ . '/../vendor/autoload.php';

use app\erp_oops_classes\Auditable;
use app\erp_oops_classes\FreeSample;
use app\erp_oops_classes\GenerateCsv;
use app\erp_oops_classes\InvoiceCalculator;
use app\erp_oops_classes\InvoiceProcessor;
use app\erp_oops_classes\Item;
use app\erp_oops_classes\Location;
use app\erp_oops_classes\OrderStatus;
use app\erp_oops_classes\PurchaseOrder;
use app\erp_oops_classes\SaveData;
use app\erp_oops_classes\StockLedger;
use app\erp_oops_classes\Supplier;
use app\erp_oops_classes\VatCalculator;
use app\erp_oops_classes\Warehouse;
use app\erp_oops_classes\Service;
use app\erp_oops_classes\Material;
use app\erp_oops_classes\AbstractArticle;
use app\erp_oops_classes\Exportable;
use app\erp_oops_classes\EmailClass;
use app\erp_oops_classes\NewEmailService;
use app\erp_oops_classes\FakeEmailNotifier;
use app\erp_oops_classes\BothChannelsNotifier;
use app\erp_oops_classes\SmsClass;
use app\erp_oops_classes\SmsNotifier;
use app\erp_oops_classes\Discount;
use app\erp_oops_classes\StandardDiscount;
use app\erp_oops_classes\BulkDiscount;




//----------------------------------------------------------------------------------

$output = new Item(1, 'Apple', stockLevel: 9);
//var_dump($output->needsReorder());

$stockLedger1 = new StockLedger();
$stockLedger2 = new StockLedger();
$stockLedger1->receiveStock(10);
$stockLedger2->receiveStock(15);
//
$warehouse = new Warehouse();
$warehouse->addItem('firstLedger', $stockLedger1);
$warehouse->addItem('secondLedger', $stockLedger2);


$service1 = new Service(AbstractArticle::generateId(), 'Service', 100);
$service2 = new Service(AbstractArticle::generateId(), 'new Service', 22);
$service3 = new Service(AbstractArticle::generateId(), 'Repair', 33);

$material1 = new Material(AbstractArticle::generateId(), 'Service', 50);
$material2 = new Material(AbstractArticle::generateId(), 'new Service', 44);
$material3 = new Material(AbstractArticle::generateId(), 'Repair', 33);

$articles = [$service1, $service2, $service3, $material1, $material2, $material3];

function calculateInvoiceTotal(array $articles):float
{
    $sum = 0;
    foreach ($articles as $article) {
       $sum += $article->getValue();
    }
    return $sum;
}
$output = calculateInvoiceTotal($articles);



$material = Material::fromCsvRow('5,Bolts,50');
$supplier = new Supplier('Google', 'google.com', 1, 'trait-testing');
function exportToCsv(Exportable $item):string
{
   return ($item->toCsvRow());
}
(exportToCsv($material));

function audiItem(Auditable $item):string
{
    return ($item->getAuditInfo());
}
(audiItem($material));

$location = new Location(1 , 'Main Office');
$a =($location->identify());

//var_dump($supplier->identify());
//var_dump($supplier->identifyLoggable());

$purchaseOrder = new PurchaseOrder(1, 'PO1',22);
$purchaseOrder->changeStatus(OrderStatus::Shipped);
//$status = OrderStatus::from('shipped');

//echo $material;
//echo "Item: ".$material;
//echo (string)$material;
//
//echo $purchaseOrder->statusLabel;
//var_dump($purchaseOrder->somethingThatDoesntExist);

$vatCalculator = new VatCalculator();
//var_dump($vatCalculator($material));
//var_dump($vatCalculator($service1));
//var_dump($purchaseOrder::createApproved('PO2',33));
//----------------- test late static binding
//var_dump($material::whoAmI());
//var_dump($material::whoCalledMe());
//var_dump($service1::whoAmI());
//var_dump($service1::whoCalledMe());
$x = Material::createBlank(AbstractArticle::generateId(), 'New Material Item', 100);
$y = Service::createBlank(AbstractArticle::generateId(), 'New Service Item', 44);
//var_dump($x::class);
//var_dump($y::class);

//-------------- first-class callable syntax
$purchaseOrder1 = new PurchaseOrder(1, 'PO1',22);
$purchaseOrder2 = new PurchaseOrder(1, 'PO1',6);
$purchaseOrder3 = new PurchaseOrder(1, 'PO1',55);
$purchaseOrder4 = new PurchaseOrder(1, 'PO1',89);

$arr = [$purchaseOrder1, $purchaseOrder2, $purchaseOrder3, $purchaseOrder4];
$array = usort($arr, PurchaseOrder::compareByTotalAmount(...));
//var_dump(array_map(fn($order1) => $order1->getTotalAmount(), $arr));
//var_dump(array_map(PurchaseOrder::formatLabel(...), $arr));

//-------------attributes
$reflection = new ReflectionClass(PurchaseOrder::class);
foreach ($reflection->getProperties() as $property) {
   $attribute = $property->getAttributes();
   if (count($attribute) > 0) {
       $instance = $attribute[0]->newInstance();
       //echo $property->getName().':'.$instance->label;
   }
}
//----------------------Single Responsibility.
$lines = [
    ['name' => 'Bolts',  'quantity' => 10, 'unitPrice' => 0.50],
    ['quantity' => 20,'name' => 'Washers', 'unitPrice' => 0.10],
];
//$invoiceCalculator = new InvoiceCalculator();
//var_dump($invoiceCalculator->calculateInvoiceVat($lines));
//$generateCsv = new GenerateCsv();
//$csv = $generateCsv->generateCsv($lines);
//echo "<pre>$csv</pre>";
//$saveData = new SaveData();
//$sendEmail = new EmailClass();
//$sendEmail->sendEmail('a@b.de', $invoiceCalculator->calculateInvoiceVat($lines));
//$saveData->saveData($lines);

//----------------------dependency injection

$invoiceProcessor = new InvoiceProcessor(new InvoiceCalculator(), new GenerateCsv(), new SaveData(), new NewEmailService());
//$invoiceProcessor->processInvoice($lines, 'a@b.de');

//----------------------Open-Closed Principle

$fake = new FakeEmailNotifier();
$invoiceProcessor = new InvoiceProcessor(new InvoiceCalculator(), new GenerateCsv(), new SaveData(), $fake);

//$invoiceProcessor->processInvoice($lines, 'a@b.de');
//var_dump($fake->getLastEmailAddress(), $fake->getLastInvoiceTotal());


//------------------------Interface Segregation
$invoiceProcessor = new InvoiceProcessor(new InvoiceCalculator(), new GenerateCsv(), new SaveData(), new BothChannelsNotifier());
//$invoiceProcessor->processInvoice($lines, 'a@b.de');

//--------------------------Liskov Substitution
$material1 = new Material(AbstractArticle::generateId(), 'Service', 10.0);
$material2 = new Material(AbstractArticle::generateId(), 'new Service', 5.0);
$freeSample = new FreeSample(AbstractArticle::generateId(), 'free-sample');

$article = [$material1, $material2, $freeSample];
$total = 0;
foreach ($article as $item) {
    $total += $item->getValue();
}
//var_dump($total);

$discount = new BulkDiscount();
$amounts = [250.0,40.0,80.0];
$totalAmount = 0;
foreach ($amounts as $amount) {
    $totalAmount += $discount->apply($amount);
}
var_dump($totalAmount);