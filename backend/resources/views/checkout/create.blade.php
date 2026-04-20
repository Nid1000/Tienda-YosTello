@extends('layouts.app', ['title' => 'YO-TELLO | Checkout'])

@section('content')
    <section class="section compact">
        <div class="container cart-checkout-shell">
            <div class="cart-main">
                <div class="checkout-steps">
                    <span>Resumen de la compra</span>
                    <span class="active">Datos del cliente</span>
                    <span>Pago y envio</span>
                </div>

                <form
                    method="POST"
                    action="{{ route('checkout.store') }}"
                    class="stack-form checkout-form-advanced"
                    data-dni-form
                    data-dni-url="{{ route('checkout.lookup-dni') }}"
                >
                    @csrf
                    <div class="panel-card">
                        <p class="eyebrow">Identificacion</p>
                        <h1>Finaliza tu compra</h1>
                        <p class="checkout-copy">Solicitamos unicamente la informacion esencial para completar el pedido. Si el cliente compra con DNI peruano, podemos autocompletar nombres desde la API.</p>

                        <div class="checkout-grid two-columns">
                            <label>
                                <span>Tipo de documento</span>
                                <select name="document_type" data-document-type required>
                                    <option value="DNI" @selected(old('document_type', 'DNI') === 'DNI')>DNI</option>
                                    <option value="CE" @selected(old('document_type') === 'CE')>C.E.</option>
                                </select>
                            </label>
                            <label>
                                <span>Documento de identidad</span>
                                <div class="lookup-row">
                                    <input type="text" name="document_number" value="{{ old('document_number') }}" data-dni-input required>
                                    <button class="button secondary" type="button" data-dni-trigger>Buscar DNI</button>
                                </div>
                                <small data-dni-feedback></small>
                            </label>
                            <label>
                                <span>Nombres</span>
                                <input type="text" name="customer_first_name" value="{{ old('customer_first_name') }}" data-first-name required>
                            </label>
                            <label>
                                <span>Apellidos</span>
                                <input type="text" name="customer_last_name" value="{{ old('customer_last_name') }}" data-last-name required>
                            </label>
                            <label>
                                <span>Nombre completo</span>
                                <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" data-full-name required>
                            </label>
                            <label>
                                <span>Telefono / movil</span>
                                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required>
                            </label>
                        </div>
                    </div>

                    <div class="panel-card">
                        <p class="eyebrow">Pago y envio</p>
                        <div class="checkout-grid two-columns">
                            <div class="delivery-methods">
                                <label class="delivery-option">
                                    <input type="radio" name="delivery_method" value="domicilio" @checked(old('delivery_method', 'domicilio') === 'domicilio')>
                                    <span>Envio a domicilio</span>
                                </label>
                                <label class="delivery-option">
                                    <input type="radio" name="delivery_method" value="recojo" @checked(old('delivery_method') === 'recojo')>
                                    <span>Recojo en tienda</span>
                                </label>
                            </div>

                            <label>
                                <span>Metodo de pago</span>
                                <select name="payment_method" required>
                                    <option value="tarjeta" @selected(old('payment_method') === 'tarjeta')>Tarjeta o billetera digital</option>
                                    <option value="transferencia" @selected(old('payment_method') === 'transferencia')>Transferencia bancaria</option>
                                    <option value="contraentrega" @selected(old('payment_method') === 'contraentrega')>Contraentrega</option>
                                </select>
                            </label>

                            <label>
                                <span>Departamento</span>
                                <input type="text" name="department" value="{{ old('department', 'Lima') }}" required>
                            </label>
                            <label>
                                <span>Provincia</span>
                                <input type="text" name="province" value="{{ old('province', 'Lima') }}" required>
                            </label>
                            <label>
                                <span>Distrito</span>
                                <input type="text" name="district" value="{{ old('district') }}" required>
                            </label>
                            <label>
                                <span>Referencia</span>
                                <input type="text" name="shipping_reference" value="{{ old('shipping_reference') }}">
                            </label>
                        </div>

                        <label>
                            <span>Direccion de envio</span>
                            <textarea name="shipping_address" rows="4" required>{{ old('shipping_address') }}</textarea>
                        </label>
                    </div>

                    <div class="panel-card checkout-actions-panel">
                        <a class="button secondary" href="{{ route('cart.index') }}">Volver al carrito</a>
                        <button class="button primary" type="submit">Confirmar pedido</button>
                    </div>
                </form>
            </div>

            <aside class="panel-card checkout-summary-card">
                <p class="eyebrow">Resumen de la compra</p>
                @foreach ($products as $product)
                    <div class="checkout-line-item">
                        <div>
                            <strong>{{ $product->name }}</strong>
                            <p>Talla: {{ $cart[$product->id]['size'] }}</p>
                        </div>
                        <div>
                            <span>{{ $cart[$product->id]['quantity'] }} und.</span>
                            <strong>S/. {{ number_format($product->final_price * $cart[$product->id]['quantity'], 2, '.', ',') }}</strong>
                        </div>
                    </div>
                @endforeach
                <div class="summary-divider"></div>
                <div class="summary-row total">
                    <span>Total estimado</span>
                    <strong>S/. {{ number_format($total, 2, '.', ',') }}</strong>
                </div>
            </aside>
        </div>
    </section>
@endsection
