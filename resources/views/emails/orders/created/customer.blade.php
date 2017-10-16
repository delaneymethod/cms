@extends('_layouts.email')

@section('content')
				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 0px solid #cccccc;border-collapse: collapse;">
					<tr>
						<td align="left" valign="top" style="border-top: 1px solid #f1f3f6;padding: 1px;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;"></td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 20px;line-height: 20px;font-weight: bold;">Thank you for your Order</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;">Hello {{ $user->first_name }},</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;">Your order has been received and is now being processed. Your order details are shown below for your reference:</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 20px;line-height: 20px;font-weight: bold;">Order #{{ $order->order_number }}</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;"><strong>PO Number:</strong> {{ $order->po_number }}<br><strong>Date:</strong> {{ $order->created_at }}</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="border-top: 1px solid #f1f3f6;padding: 1px;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;"></td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 20px;line-height: 20px;font-weight: bold;">Order Items</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 20px;line-height: 20px;">
							<table border="1" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #f1f3f6;border-collapse: collapse;">
								<tr>
									<td align="center" valign="middle" style="padding: 15px 15px 15px 15px;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;font-weight: bold;">&nbsp;</td>
									<td align="left" valign="middle" style="padding: 15px 15px 15px 15px;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;font-weight: bold;">Product</td>
									<td align="center" valign="middle" style="padding: 15px 15px 15px 15px;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;font-weight: bold;">Qty</td>
									<td align="center" valign="middle" style="padding: 15px 15px 15px 15px;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;font-weight: bold;">Tax</td>
									<td align="center" valign="middle" style="padding: 15px 15px 15px 15px;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;font-weight: bold;">Price</td>
									<td align="center" valign="middle" style="padding: 15px 15px 15px 15px;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;font-weight: bold;">Total</td>
								</tr>
								@foreach ($order->product_commodities as $productCommodity)
									<tr>
										<td align="center" valign="middle" style="padding: 15px 15px 15px 15px;font-family: Arial, sans-serif;font-size: 12px;line-height: 18px;"><a href="{{ config('app.url') }}{{ $productCommodity->product->url }}#{{ $productCommodity->code }}" title="{{ $productCommodity->product->title }}" target="_blank"><img src="{{ $productCommodity->product->image_url }}" style="width: 60px;height: 60px;" alt="{{ $productCommodity->product->title }}"></a></td>
										<td align="left" valign="middle" style="padding: 15px 15px 15px 15px;font-family: Arial, sans-serif;font-size: 12px;line-height: 18px;"><a href="{{ config('app.url') }}{{ $productCommodity->product->url }}#{{ $productCommodity->code }}" title="{{ $productCommodity->product->title }}" target="_blank">{{ $productCommodity->title }}</a><br>Code: {{ $productCommodity->code }}</td>
										<td align="center" valign="middle" style="padding: 15px 15px 15px 15px;font-family: Arial, sans-serif;font-size: 12px;line-height: 18px;">{{ $productCommodity->pivot->quantity }}</td>
										<td align="center" valign="middle" style="padding: 15px 15px 15px 15px;font-family: Arial, sans-serif;font-size: 12px;line-height: 18px;">{{ $productCommodity->pivot->tax_rate }}&#37;</td>
										<td align="center" valign="middle" style="padding: 15px 15px 15px 15px;font-family: Arial, sans-serif;font-size: 12px;line-height: 18px;">{{ $order->currency.number_format($productCommodity->pivot->price, 2, '.', ',') }}</td>
										<td align="center" valign="middle" style="padding: 15px 15px 15px 15px;font-family: Arial, sans-serif;font-size: 12px;line-height: 18px;">{{ $order->currency.number_format($productCommodity->pivot->price_tax, 2, '.', ',') }}</td>
									</tr>
								@endforeach
							</table>
						</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 20px;line-height: 20px;font-weight: bold;">Order Notes</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;">{{ $order->notes ?? 'N/A' }}</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="border-top: 1px solid #f1f3f6;padding: 1px;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;"></td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 20px;line-height: 20px;font-weight: bold;">Customer</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;">	
							<strong>Full Name:</strong> {{ $user->first_name }} {{ $user->last_name }}<br><strong>Email:</strong> <a href="mailto:{{ $user->email }}" title="Email {{ $user->first_name }}">{{ $user->email }}</a><br><strong>Tel:</strong> {{ $user->telephone }}<br><strong>Mob:</strong> {{ $user->mobile }}<br><br><strong>Company:</strong><br>{{ $user->company->title }}
						</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="border-top: 1px solid #f1f3f6;padding: 1px;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;"></td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 0 0 0 0;font-family: Arial, sans-serif;font-size: 20px;line-height: 20px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 0px solid #cccccc;border-collapse: collapse;">
								<tr>
									<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 20px;line-height: 20px;font-weight: bold;">Billing Address</td>
									<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 20px;line-height: 20px;font-weight: bold;">Shipping Address</td>
								</tr>
								<tr>
									<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;">{{ $user->location->title }}<br>{!! nl2br($user->location_postal_address) !!}</td>
									<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;">{!! nl2br($order->postal_address) !!}</td>
								</tr>
								<tr>
									<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;"></td>
									<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;">
										<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 0px solid #cccccc;border-collapse: collapse;">
											<tr>
												<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;font-weight: bold;">Shipping Method</td>
											</tr>
											<tr>
												<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;">{{ $order->shipping_method->title }}</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="border-top: 1px solid #f1f3f6;padding: 1px;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;"></td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 20px;line-height: 20px;font-weight: bold;">Additional Information</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding: 15px 0 15px 0;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;"><a href="{{ config('app.url') }}/login?redirectTo=/cp/orders/{{ $order->id }}/pdf" title="Download PDF version of your Order">Download PDF version of your Order</a></td>
					</tr>
					<tr>
						<td align="left" valign="top" style="border-top: 1px solid #f1f3f6;padding: 1px;font-family: Arial, sans-serif;font-size: 14px;line-height: 20px;"></td>
					</tr>
				</table>
@endsection
