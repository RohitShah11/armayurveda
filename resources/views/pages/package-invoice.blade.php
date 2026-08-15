<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Package Invoice {{ $invoiceNumber }}</title>
<style>
:root{--green:#075127;--gold:#d5a521;--line:#dbe1dc;--soft:#fffaf0}*{box-sizing:border-box}body{margin:0;background:#e9ecef;color:#171717;font:12px/1.4 Arial,sans-serif}.sheet{width:210mm;min-height:297mm;margin:20px auto;background:#fff;box-shadow:0 4px 20px #0002;overflow:hidden;position:relative}.sheet:before{content:"";position:absolute;width:220px;height:220px;border:35px solid #c79b2710;border-radius:50%;right:-110px;top:-110px}.content{position:relative;padding:10mm 9mm 0}.header{display:flex;justify-content:space-between;gap:22px}.brand{display:flex;gap:12px}.logo{width:88px;height:88px;object-fit:contain}.company h1{margin:0;color:var(--green);font-size:25px;line-height:1.05;text-transform:uppercase}.tag{display:inline-block;margin:7px 0 5px;padding:4px 9px;border-left:3px solid var(--gold);background:#f5f7ed;color:#164b2d;font-weight:700}.contact{line-height:1.65}.title{min-width:280px;text-align:right}.title h2{margin:0 0 9px;color:var(--green);font-size:34px;letter-spacing:1px}.meta{border:1px solid #b9c7bc;border-radius:8px;padding:8px 11px;text-align:left}.info-row{display:grid;grid-template-columns:108px 1fr;gap:8px;margin:3px 0}.info-row b:after{content:":";float:right}.status{color:var(--green);font-weight:700}.divider{height:10px;margin:14px -9mm 14px;border-top:3px solid var(--gold);background:var(--green)}.addresses{display:grid;grid-template-columns:1fr 1fr;gap:28px;margin-bottom:14px}.address:first-child{border-right:1px solid #ccd4cd}.heading{display:inline-block;margin-bottom:7px;padding:4px 14px;border-radius:5px;background:var(--green);color:#fff;font-weight:700;text-transform:uppercase}.address p{display:grid;grid-template-columns:100px 1fr;gap:7px;margin:3px 0}.address strong:after{content:":";float:right}.table-scroll{overflow:visible}.items{width:100%;border:1px solid var(--line);border-collapse:separate;border-spacing:0;border-radius:8px;overflow:hidden}.items th{padding:7px 5px;background:var(--green);color:#fff;font-size:11px}.items td{height:42px;padding:5px;border-right:1px solid #e5e8e5;border-bottom:1px solid #e5e8e5;text-align:right}.items tr:last-child td{border-bottom:0}.items td:last-child{border-right:0;color:var(--green);font-weight:700}.items td:first-child{text-align:center}.items td:nth-child(2){text-align:left}.product strong{display:block}.product small{color:#555}.summary{display:grid;grid-template-columns:1fr 340px;gap:18px;margin-top:12px}.words{min-height:72px;padding:10px 13px;border-left:4px solid var(--gold);border-radius:5px;background:var(--soft)}.totals div{display:flex;justify-content:space-between;padding:4px 8px;border-bottom:1px solid #ddd}.totals .grand{margin-top:4px;border:0;border-radius:5px;background:var(--green);color:#fff;font-size:15px;font-weight:700}.tax-note{padding:3px 8px!important;border:0!important;color:var(--green);font-size:10px}.bottom{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:13px;padding:10px 13px;border:1px solid var(--line);border-radius:8px;background:#fcfdf9}.details h3{margin:0 0 7px;color:var(--green);font-size:11px;text-transform:uppercase}.thanks{display:flex;flex-direction:column;justify-content:center;text-align:center}.thanks strong{color:var(--green);font:italic 23px Georgia}.thanks p{margin:5px 0 0;font-size:10px}.footer{display:flex;justify-content:center;gap:30px;margin:14px -9mm 0;padding:8px 12px;background:var(--green);color:#fff;font-size:10px}.actions{width:210mm;margin:0 auto 25px;display:flex;justify-content:space-between}.btn{border:0;border-radius:5px;padding:11px 20px;background:var(--green);color:#fff;text-decoration:none;font-weight:700;cursor:pointer}.secondary{background:#555}@media screen and (max-width:850px){.sheet{width:100%;min-height:auto;margin:0}.content{padding:18px 14px 0}.header,.addresses,.summary,.bottom{grid-template-columns:1fr;display:grid}.title{min-width:0;text-align:left}.address:first-child{border:0;border-bottom:1px solid #ddd;padding-bottom:10px}.table-scroll{overflow-x:auto}.items{min-width:750px}.divider,.footer{margin-left:-14px;margin-right:-14px}.actions{width:100%;padding:14px}}@media print{@page{size:A4 portrait;margin:0}html,body{width:210mm;height:297mm;background:#fff;-webkit-print-color-adjust:exact!important;print-color-adjust:exact!important}.sheet{width:210mm;height:297mm;min-height:0;margin:0;box-shadow:none}.content{padding:8mm 8mm 0}.header{display:flex}.divider,.footer{margin-left:-8mm;margin-right:-8mm}.addresses{margin-bottom:10px}.items td{height:38px}.summary{grid-template-columns:1fr 330px}.bottom{margin-top:10px}.actions{display:none}.header,.addresses,.summary,.bottom,.footer{break-inside:avoid}}
</style>
</head>
<body>
@php
$purchase = $packagePurchase;
$customer = $purchase->user;
$address = collect([$profile?->address, $profile?->city ?: $customer->city, $profile?->state ?: $customer->state, $profile?->pincode])->filter()->implode(', ');
$products = [
    ['name' => 'Red Aloe Vera Juice', 'size' => '500 ml', 'mrp' => 999.00, 'taxable' => 797.32, 'gst' => 39.87, 'total' => 837.19],
    ['name' => 'ARM Hair Oil', 'size' => '100 ml', 'mrp' => 299.00, 'taxable' => 238.64, 'gst' => 11.93, 'total' => 250.57],
    ['name' => 'ARM Shampoo', 'size' => '200 ml', 'mrp' => 799.00, 'taxable' => 637.69, 'gst' => 31.88, 'total' => 669.57],
    ['name' => 'ARM Tulsi Drops', 'size' => '30 ml', 'mrp' => 225.00, 'taxable' => 179.58, 'gst' => 8.98, 'total' => 188.56],
    ['name' => 'Calcium Tablets', 'size' => '30 pcs', 'mrp' => 242.00, 'taxable' => 193.15, 'gst' => 9.66, 'total' => 202.81],
    ['name' => 'Premium Backpack', 'size' => '', 'mrp' => 1500.00, 'taxable' => 1197.19, 'gst' => 59.86, 'total' => 1257.05],
    ['name' => 'Multivitamin Tablets', 'size' => '60 pcs', 'mrp' => 999.00, 'taxable' => 797.33, 'gst' => 39.87, 'total' => 837.20],
    ['name' => 'Dinner Set', 'size' => '8 pcs', 'mrp' => 1500.00, 'taxable' => 1197.19, 'gst' => 59.86, 'total' => 1257.05],
];
@endphp
<main class="sheet">
<div class="content">
<header class="header">
    <div class="brand"><img class="logo" src="{{ asset('images/arm-ayurveda-logo.png') }}" alt="ARM Ayurveda"><div class="company"><h1>ARM Ayurveda<br>Pvt. Ltd.</h1><div class="tag">Healthy Life, Natural Future</div><div class="contact">Phone: +91 92420 68805<br>Email: armayurveda@gmail.com<br>Ashoknagar, North 24 Parganas,<br>West Bengal</div></div></div>
    <div class="title"><h2>PACKAGE INVOICE</h2><div class="meta"><div class="info-row"><b>Invoice No.</b><span>{{ $invoiceNumber }}</span></div><div class="info-row"><b>Invoice Date</b><span>{{ $purchase->purchase_date?->format('d-m-Y') }}</span></div><div class="info-row"><b>Payment Mode</b><span>Main Wallet</span></div><div class="info-row"><b>Payment Status</b><span class="status">{{ $purchase->status }}</span></div></div></div>
</header>
<div class="divider"></div>
<section class="addresses">
@foreach(['Bill To', 'Activation For'] as $type)
    <div class="address"><div class="heading">{{ $type }}</div><p><strong>Member Name</strong><span>{{ $customer->name }}</span></p><p><strong>Member ID</strong><span>{{ $customer->member_id ?: '—' }}</span></p><p><strong>Mobile</strong><span>{{ $profile?->mobile ?: $customer->mobile ?: '—' }}</span></p><p><strong>Email</strong><span>{{ $customer->email ?: '—' }}</span></p><p><strong>Address</strong><span>{{ $address ?: 'Not provided' }}</span></p></div>
@endforeach
</section>
<div class="table-scroll"><table class="items"><thead><tr><th>#</th><th>Product / Package</th><th>MRP (₹)</th><th>Selling Price<br>(Excl. GST)</th><th>GST 5%</th><th>Selling Price<br>(Incl. GST)</th></tr></thead><tbody>
@foreach($products as $product)
<tr><td>{{ $loop->iteration }}</td><td class="product"><strong>{{ $product['name'] }}</strong>@if($product['size'])<small>{{ $product['size'] }}</small>@endif</td><td>{{ number_format($product['mrp'], 2) }}</td><td>{{ number_format($product['taxable'], 2) }}</td><td>{{ number_format($product['gst'], 2) }}</td><td>{{ number_format($product['total'], 2) }}</td></tr>
@endforeach
</tbody></table></div>
<section class="summary"><div class="words"><strong>Amount in Words</strong><br>Five thousand five hundred rupees only</div><div class="totals"><div><span>Total MRP</span><b>₹6,563.00</b></div><div><span>Total Selling Price (Excl. GST)</span><b>₹5,238.09</b></div><div><span>Total GST @ 5%</span><b>₹261.91</b></div><div class="grand"><span>Grand Total (Incl. GST)</span><span>₹5,500.00</span></div><div class="tax-note">* GST @ 5% (CGST 2.5% + SGST 2.5%)</div></div></section>
<section class="bottom"><div class="details"><h3>Package Activation Details</h3><div class="info-row"><b>Package</b><span>{{ $purchase->package_name }}</span></div><div class="info-row"><b>Purchase Date</b><span>{{ $purchase->purchase_date?->format('d M Y, h:i A') }}</span></div><div class="info-row"><b>Activation Status</b><span class="status">{{ $purchase->status }}</span></div><div class="info-row"><b>Payment Source</b><span>Main Wallet</span></div></div><div class="thanks"><strong>Thank You!</strong><p>Thank you for choosing ARM Ayurveda.<br>We wish you good health and a better tomorrow.</p></div></section>
<footer class="footer"><span>www.armayurveda.com</span><span>+91 92420 68805</span><span>armayurveda@gmail.com</span></footer>
</div>
</main>
<div class="actions"><a class="btn secondary" href="{{ route('package.purchase') }}">Back to Package Purchase</a><button class="btn" onclick="window.print()">Print / Save PDF</button></div>
</body>
</html>
