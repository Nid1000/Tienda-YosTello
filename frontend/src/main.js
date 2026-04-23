const apiFromVite = import.meta?.env?.VITE_API_BASE_URL;
const apiFromMeta = document.querySelector('meta[name="api-base-url"]')?.getAttribute('content');
const apiBase = (apiFromVite || apiFromMeta || 'http://127.0.0.1:8000/api').replace(/\/$/, '');
const backendBase = apiBase.replace(/\/api$/, '');
const authInitial = document.querySelector('meta[name="auth-user-initial"]')?.getAttribute('content')?.trim();
const authName = document.querySelector('meta[name="auth-user-name"]')?.getAttribute('content')?.trim();
const logoutUrl = document.querySelector('meta[name="logout-url"]')?.getAttribute('content') || `${backendBase}/logout`;
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
const app = document.querySelector('#app');
const accountAction = authInitial
    ? `<button class="topbar-action account-action" data-panel-target="account"><span class="account-initial-badge">${authInitial.slice(0, 1).toUpperCase()}</span><span>Cuenta</span></button>`
    : '<button class="topbar-action" data-panel-target="account">Cuenta</button>';
const accountMenu = authInitial
    ? `
        <div class="account-user-card">
            <span class="account-initial-large">${authInitial.slice(0, 1).toUpperCase()}</span>
            <div>
                <strong>${authName || 'Mi cuenta'}</strong>
                <small>Sesion iniciada</small>
            </div>
        </div>
        <a href="${backendBase}/pedidos">Mis pedidos</a>
        <a href="${backendBase}/dashboard">Mi cuenta</a>
        <form class="account-logout-form" method="POST" action="${logoutUrl}">
            <input type="hidden" name="_token" value="${csrfToken}">
            <button type="submit">Cerrar sesion</button>
        </form>
    `
    : `
        <a href="${backendBase}/login" data-bridge-target="cart">Iniciar sesion</a>
        <a href="${backendBase}/registro">Crear cuenta</a>
    `;

app.innerHTML = `
    <div class="page-shell">
        <div class="topbar">
            <button class="topbar-contact" data-panel-target="contact">+ Pongase en contacto con nosotros</button>
            <a class="topbar-brand" href="#" data-go-home>YO-TELLO</a>
            <div class="topbar-right">
                ${accountAction}
                <a class="topbar-action" href="${backendBase}/productos">Buscar</a>
                <button class="topbar-action" data-panel-target="menu">Menu</button>
            </div>
        </div>

        <div id="overlay" class="overlay hidden"></div>

        <section id="cart-dialog" class="cart-dialog hidden">
            <div class="cart-dialog-card">
                <div class="cart-dialog-head">
                    <strong>Se ha anadido a la bolsa</strong>
                    <button class="dialog-close" data-close-panel>x</button>
                </div>
                <div id="cart-dialog-body" class="cart-dialog-body"></div>
                <div class="cart-dialog-actions">
                    <a class="dialog-button primary-dialog" href="${backendBase}/checkout" target="_blank" rel="noreferrer" data-bridge-target="checkout">Finalizar la compra</a>
                    <button class="dialog-button secondary-dialog" data-open-bag>Ver bolsa de compra</button>
                </div>
            </div>
        </section>

        <section id="size-panel" class="size-panel hidden">
            <button class="size-close" data-close-panel>x</button>
            <div class="size-shell">
                <p class="size-kicker">Tallas</p>
                <h2>Guia de tallas</h2>
                <div class="size-list">
                    <button class="size-option active-size">XS / 36</button>
                    <button class="size-option">S / 38</button>
                    <button class="size-option">M / 40</button>
                    <button class="size-option">L / 42</button>
                    <button class="size-option">XL / 44</button>
                </div>
            </div>
        </section>

        <section id="product-panel" class="product-panel hidden">
            <button class="product-close" data-close-panel aria-label="Cerrar producto">x</button>
            <div id="product-detail" class="product-detail"></div>
        </section>

        <section id="contact-panel" class="contact-panel hidden">
            <div id="contact-visual" class="contact-visual">
                <div class="contact-visual-copy">
                    <span>Atencion YO-TELLO</span>
                    <strong>Asesoria de compra y ayuda con tu pedido</strong>
                </div>
            </div>
            <div class="contact-content">
                <button class="contact-close" data-close-panel aria-label="Cerrar panel de contacto">x</button>
                <div class="contact-copy">
                    <p class="contact-kicker">Servicio personalizado</p>
                    <h2>Contacte con nuestro equipo</h2>
                </div>
                <div class="contact-links">
                    <article class="contact-item">
                        <span class="contact-icon">Tel</span>
                        <div>
                            <a href="tel:+573229100100">Llamenos +57 322 910 0100</a>
                            <p>De lunes a domingo de las 10 de la manana a las 19 de la tarde.</p>
                        </div>
                    </article>
                    <article class="contact-item">
                        <span class="contact-icon">WA</span>
                        <div>
                            <a href="https://wa.me/573229100100" target="_blank" rel="noreferrer">Envienos un WhatsApp</a>
                            <p>Respuestas rapidas para stock, tallas, pagos y envios.</p>
                        </div>
                    </article>
                    <article class="contact-item highlight-item">
                        <span class="contact-dot"></span>
                        <div>
                            <a href="mailto:hola@yotello.com">Chat en directo</a>
                            <p>Le guiamos en compras, devoluciones y seguimiento del pedido.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section id="account-panel" class="account-panel hidden">
            <button class="account-close" data-close-panel aria-label="Volver atras">x</button>
            <div id="account-visual" class="account-visual">
                <div class="account-visual-copy">
                    <span>Cuenta YO-TELLO</span>
                    <strong>Accede a tus pedidos, direcciones y seleccion guardada</strong>
                </div>
            </div>
            <div class="account-card-wrap">
                <div class="account-card">
                    ${accountMenu}
                </div>
            </div>
        </section>

        <section id="menu-panel" class="menu-panel hidden">
            <div id="menu-visual" class="menu-visual">
                <div class="menu-visual-copy">
                    <span>YO-TELLO</span>
                    <strong>Explora colecciones, servicios y piezas seleccionadas</strong>
                </div>
            </div>
            <div class="menu-content">
                <button class="menu-close" data-close-panel aria-label="Cerrar menu">x</button>
                <div class="menu-columns">
                    <nav class="menu-primary">
                        <a href="${backendBase}/productos" target="_blank" rel="noreferrer">Novedades</a>
                        <a href="${backendBase}/productos?category=ropa" target="_blank" rel="noreferrer">Ropa</a>
                        <a href="${backendBase}/productos?category=zapatillas" target="_blank" rel="noreferrer">Zapatillas</a>
                        <a href="${backendBase}/productos?category=accesorios" target="_blank" rel="noreferrer">Accesorios</a>
                        <a href="${backendBase}/productos?category=bolsos" target="_blank" rel="noreferrer">Bolsos</a>
                    </nav>
                    <div class="menu-secondary">
                        <a href="${backendBase}/productos" target="_blank" rel="noreferrer">Catalogo completo</a>
                        <a href="${backendBase}/admin" target="_blank" rel="noreferrer">Administrador</a>
                        <a href="${backendBase}/login" target="_blank" rel="noreferrer" data-bridge-target="cart">Iniciar sesion</a>
                        <a href="${backendBase}/pedidos" target="_blank" rel="noreferrer">Mis pedidos</a>
                        <a href="mailto:hola@yotello.com">Pongase en contacto con nosotros</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="search-panel" class="search-panel hidden">
            <div class="search-shell">
                <div class="search-head">
                    <div class="search-brand">YO-TELLO</div>
                    <button class="search-close" data-close-panel>Cerrar</button>
                </div>
                <div class="search-top">
                    <label class="search-label" for="search-input">Buscar.</label>
                    <input id="search-input" class="search-input" type="search" placeholder="Busca bolsos, vestidos, zapatillas o accesorios">
                    <div class="search-tags">
                        <span>Busquedas populares</span>
                        <button class="search-tag" data-search-term="bolsos">Bolsos</button>
                        <button class="search-tag" data-search-term="zapatillas">Zapatillas</button>
                        <button class="search-tag" data-search-term="chaqueta">Chaquetas</button>
                        <button class="search-tag" data-search-term="pantalon">Pantalones</button>
                    </div>
                </div>
                <div class="search-layout">
                    <aside class="search-sidebar">
                        <div class="search-side-block">
                            <strong>Novedad</strong>
                            <button class="search-link" data-search-term="mujer">Mujer</button>
                            <button class="search-link" data-search-term="hombre">Hombre</button>
                        </div>
                        <div class="search-side-block">
                            <strong>Sugerencias</strong>
                            <a href="${backendBase}/productos" target="_blank" rel="noreferrer">Catalogo completo</a>
                            <a href="${backendBase}/admin" target="_blank" rel="noreferrer">Panel admin</a>
                        </div>
                    </aside>
                    <div class="search-results-shell">
                        <div class="search-results-head">
                            <strong>Mas popular</strong>
                            <span id="search-meta">Productos conectados a tu tienda</span>
                        </div>
                        <div id="search-results" class="search-results"></div>
                    </div>
                </div>
            </div>
        </section>

        <section id="bag-panel" class="bag-view hidden">
            <div class="bag-shell">
                <div class="bag-hero">
                    <div class="bag-copy">
                        <p class="bag-eyebrow">Sus selecciones</p>
                        <h2 id="bag-heading">Su bolsa de compra esta actualmente vacia</h2>
                        <div class="bag-hero-actions">
                            <a class="campaign-button bag-primary-link" href="${backendBase}/productos" target="_blank" rel="noreferrer">Seguir comprando</a>
                            <a class="bag-secondary-link" href="${backendBase}/checkout" target="_blank" rel="noreferrer">Ir a checkout</a>
                        </div>
                    </div>
                    <div class="bag-support">
                        <div class="bag-support-card">
                            <a href="tel:+573229100100">+57 322 910 0100</a>
                            <a href="mailto:hola@yotello.com">hola@yotello.com</a>
                        </div>
                    </div>
                </div>
                <div id="bag-content" class="bag-content"></div>
            </div>
        </section>

        <main>
            <section class="category-stage">
                <div id="category-grid" class="category-grid">
                    <div class="category-placeholder">Cargando coleccion...</div>
                </div>
            </section>

            <section class="campaign-band">
                <div class="campaign-copy">
                    <p class="campaign-kicker">Nueva temporada YO-TELLO</p>
                    <h1>Prendas esenciales para elevar tu estilo diario.</h1>
                    <a href="#featured-products" class="campaign-button">Comprar</a>
                </div>
            </section>

            <section class="editorial-section backend-strip">
                <div class="section-copy">
                    <p class="section-kicker">Tienda actualizada</p>
                    <h2>Catálogo listo para comprar</h2>
                    <p>Productos, categorías y stock conectados en tiempo real para que compres con claridad y seguridad.</p>
                </div>
                <div id="backend-stats" class="backend-stats">
                    <div class="stat-card muted-card">Cargando informacion de la tienda...</div>
                </div>
            </section>

            <section class="editorial-section" id="featured-products">
                <div class="section-copy dark-copy">
                    <p class="section-kicker">Destacados</p>
                    <h2>Seleccion principal</h2>
                </div>
                <div id="featured-grid" class="product-editorial-grid">
                    <div class="product-loading">Cargando productos destacados...</div>
                </div>
            </section>

            <section class="promo-runway" id="active-promotions">
                <div class="promo-runway-copy">
                    <p class="section-kicker">Campanas activas</p>
                    <h2>Ofertas exclusivas de temporada</h2>
                    <p>Promociones creadas desde el panel administrador para destacar lanzamientos, codigos y colecciones especiales.</p>
                    <a class="campaign-button" href="${backendBase}/admin/promociones" target="_blank" rel="noreferrer">Administrar promociones</a>
                </div>
                <div id="promotions-grid" class="promotions-grid">
                    <div class="product-loading">Cargando promociones...</div>
                </div>
            </section>

            <section class="editorial-section latest-section" id="latest-products">
                <div class="section-copy dark-copy">
                    <p class="section-kicker">Catalogo completo</p>
                    <h2>Todos los productos</h2>
                </div>
                <div id="latest-grid" class="latest-grid">
                    <div class="product-loading">Cargando todos los productos...</div>
                </div>
            </section>

            <section class="luxury-services">
                <p class="section-kicker">Servicios YO-TELLO</p>
                <div class="service-grid">
                    <article class="service-card">
                        <div
                            class="service-image"
                            style="background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.08), rgba(0, 0, 0, 0.28)), url('${backendBase}/services/appointment.jpg');"
                        ></div>
                        <strong>Reservar cita</strong>
                        <p>Atencion personalizada para elegir piezas, tallas y combinaciones con calma.</p>
                        <a href="mailto:hola@yotello.com" target="_blank" rel="noreferrer">Reservar ahora</a>
                    </article>
                    <article class="service-card">
                        <div
                            class="service-image"
                            style="background-image: linear-gradient(180deg, rgba(61, 32, 0, 0.12), rgba(61, 32, 0, 0.34)), url('${backendBase}/services/personalization.jpg');"
                        ></div>
                        <strong>Personalizacion</strong>
                        <p>Detalles especiales, empaques cuidados y una experiencia mas exclusiva.</p>
                        <a href="${backendBase}/productos" target="_blank" rel="noreferrer">Descubrir</a>
                    </article>
                    <article class="service-card">
                        <div
                            class="service-image"
                            style="background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.08), rgba(0, 0, 0, 0.24)), url('${backendBase}/services/pickup.jpg');"
                        ></div>
                        <strong>Recogida en tienda</strong>
                        <p>Compra online y recoge tu pedido en el punto que prefieras.</p>
                        <a href="${backendBase}/checkout" target="_blank" rel="noreferrer">Como funciona</a>
                    </article>
                </div>
            </section>

            <footer class="luxury-footer">
                <div class="newsletter-hero">
                    <p>Registrate para recibir novedades</p>
                    <h2>Reciba actualizaciones exclusivas sobre nuevas colecciones, servicios y lanzamientos.</h2>
                    <a href="mailto:hola@yotello.com" target="_blank" rel="noreferrer">+ Suscribirse</a>
                </div>
                <div class="footer-columns">
                    <div>
                        <h3>Ayuda</h3>
                        <a href="mailto:hola@yotello.com">Contacto</a>
                        <a href="${backendBase}/pedidos" target="_blank" rel="noreferrer">Mi pedido</a>
                        <a href="${backendBase}/productos" target="_blank" rel="noreferrer">Mapa del sitio</a>
                    </div>
                    <div>
                        <h3>Empresa</h3>
                        <a href="${backendBase}/admin" target="_blank" rel="noreferrer">Panel administrador</a>
                        <a href="${backendBase}/productos" target="_blank" rel="noreferrer">Colecciones</a>
                        <a href="${backendBase}/login" target="_blank" rel="noreferrer" data-bridge-target="cart">Iniciar sesion</a>
                    </div>
                    <div>
                        <h3>Servicios</h3>
                        <a href="mailto:hola@yotello.com">Reservar cita</a>
                        <a href="${backendBase}/checkout" target="_blank" rel="noreferrer">Checkout</a>
                        <a href="${backendBase}/carrito" target="_blank" rel="noreferrer">Bolsa</a>
                    </div>
                </div>
                <div class="footer-mark">
                    <span class="footer-mark-symbol">YT</span>
                    <strong>YO-TELLO</strong>
                </div>
            </footer>
        </main>
    </div>
`;

const overlay = document.querySelector('#overlay');
const contactVisual = document.querySelector('#contact-visual');
const menuVisual = document.querySelector('#menu-visual');
const accountVisual = document.querySelector('#account-visual');
const categoryGrid = document.querySelector('#category-grid');
const backendStats = document.querySelector('#backend-stats');
const featuredGrid = document.querySelector('#featured-grid');
const promotionsGrid = document.querySelector('#promotions-grid');
const latestGrid = document.querySelector('#latest-grid');
const bagCount = document.querySelector('#bag-count');
const bagContent = document.querySelector('#bag-content');
const bagHeading = document.querySelector('#bag-heading');
const searchInput = document.querySelector('#search-input');
const searchResults = document.querySelector('#search-results');
const productDetail = document.querySelector('#product-detail');
const cartDialogBody = document.querySelector('#cart-dialog-body');

const state = {
    products: [],
    cart: JSON.parse(localStorage.getItem('yotello-cart') || '[]'),
    selectedSize: 'M / 40',
    activeProductId: null,
};

state.cart = (Array.isArray(state.cart) ? state.cart : []).map((item) => ({
    ...item,
    size: item?.size || 'M / 40',
}));

const formatCurrency = (value) => new Intl.NumberFormat('es-CO', {
    style: 'currency',
    currency: 'COP',
    maximumFractionDigits: 0,
}).format(value || 0);

const persistCart = () => localStorage.setItem('yotello-cart', JSON.stringify(state.cart));

const removeFromBag = (productId) => {
    state.cart = state.cart.filter((item) => item.id !== productId);
    persistCart();
    renderBag();
};

const openBackendWithCart = (target, fallbackHref) => {
    if (!state.cart.length) {
        window.open(fallbackHref, '_blank', 'noopener,noreferrer');
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `${backendBase}/bridge/cart`;
    form.target = '_blank';
    form.style.display = 'none';

    const targetInput = document.createElement('input');
    targetInput.type = 'hidden';
    targetInput.name = 'target';
    targetInput.value = target;

    const cartInput = document.createElement('input');
    cartInput.type = 'hidden';
    cartInput.name = 'cart';
    cartInput.value = JSON.stringify(state.cart.map((item) => ({
        id: item.id,
        qty: item.qty,
        size: item.size || state.selectedSize,
    })));

    form.appendChild(targetInput);
    form.appendChild(cartInput);
    document.body.appendChild(form);
    form.submit();
    form.remove();
};

const openPanel = (target) => {
    document.querySelectorAll('.contact-panel, .account-panel, .menu-panel, .search-panel, .product-panel, .bag-view, .size-panel, .cart-dialog')
        .forEach((panel) => panel.classList.add('hidden'));
    overlay.classList.remove('hidden');
    document.querySelector(`#${target}-panel, #${target}`)?.classList.remove('hidden');
};

const closePanels = () => {
    document.querySelectorAll('.contact-panel, .account-panel, .menu-panel, .search-panel, .product-panel, .bag-view, .size-panel, .cart-dialog')
        .forEach((panel) => panel.classList.add('hidden'));
    overlay.classList.add('hidden');
};

const openProductDetail = (productId) => {
    const product = state.products.find((item) => item.id === productId);
    if (!product) return;

    state.activeProductId = productId;

    const related = state.products.filter((item) => item.category === product.category).slice(0, 4);
    productDetail.innerHTML = `
        <div class="product-hero">
            <div class="product-hero-image">
                <img src="${product.image}" alt="${product.name}">
            </div>
            <div class="product-thumb-row">
                ${(related.length ? related : [product]).map((item) => `
                    <button class="product-thumb ${item.id === product.id ? 'active-thumb' : ''}" data-open-product="${item.id}">
                        <img src="${item.image}" alt="${item.name}">
                    </button>
                `).join('')}
            </div>
        </div>
        <div class="product-content">
            <div class="product-copy-area">
                <span class="product-category">${product.category}</span>
                <h2>${product.name}</h2>
                <strong class="product-price">${formatCurrency(product.final_price ?? product.price)}</strong>
                <p class="product-description">${product.description}</p>
                <div class="product-size-row">
                    <span>Talla: ${state.selectedSize}</span>
                    <button class="product-plus" data-open-size type="button">+</button>
                </div>
                <div class="product-accordion">
                    <button type="button">Detalles del producto</button>
                    <button type="button">Materiales y cuidado</button>
                    <button type="button">Nuestro compromiso</button>
                </div>
            </div>
            <aside class="product-side">
                <button class="product-buy" data-add-id="${product.id}">Anadir a la bolsa de compras</button>
                <a class="product-window-link" href="${backendBase}/productos" target="_blank" rel="noreferrer">Ver catalogo completo</a>
                <div class="product-note">
                    <strong>Contactar con nuestro equipo</strong>
                    <p>Nuestros asesores de clientes estan a su disposicion.</p>
                </div>
                <div class="product-note">
                    <strong>Servicios YO-TELLO</strong>
                    <p>Envio gratuito, cambios sencillos y empaque premium.</p>
                </div>
            </aside>
        </div>
    `;

    bindProductCards(productDetail);
    bindAddButtons(productDetail);
    productDetail.querySelector('[data-open-size]')?.addEventListener('click', () => openPanel('size'));
    openPanel('product');
};

const showCartDialog = (product) => {
    cartDialogBody.innerHTML = `
        <img src="${product.image}" alt="${product.name}">
        <div>
            <strong>${product.name}</strong>
            <p>${formatCurrency(product.final_price ?? product.price)}</p>
            <span>Categoria: ${product.category}</span>
        </div>
    `;
    openPanel('cart-dialog');
};

const addToBag = (productId) => {
    const product = state.products.find((item) => item.id === productId);
    if (!product) return;

    const existing = state.cart.find((item) => item.id === productId);
    if (existing) {
        existing.qty += 1;
        existing.size = existing.size || state.selectedSize;
    } else {
        state.cart.push({
            id: product.id,
            name: product.name,
            category: product.category,
            image: product.image,
            final_price: product.final_price ?? product.price,
            qty: 1,
            size: state.selectedSize,
        });
    }

    persistCart();
    renderBag();
    showCartDialog(product);
};

const renderBag = () => {
    const totalItems = state.cart.reduce((sum, item) => sum + item.qty, 0);
    if (bagCount) {
        bagCount.textContent = String(totalItems);
    }

    if (state.cart.length === 0) {
        bagHeading.textContent = 'Su bolsa de compra esta actualmente vacia';
        bagContent.innerHTML = `
            <div class="bag-empty-layout">
                <div class="bag-empty-visual"></div>
                <div class="bag-recommendations">
                    <h3>Quizas tambien le guste</h3>
                    <div class="bag-product-strip">
                        ${state.products.slice(0, 4).map((product) => `
                            <article class="bag-suggestion" data-open-product="${product.id}">
                                <img src="${product.image}" alt="${product.name}">
                                <strong>${product.name}</strong>
                                <span>${formatCurrency(product.final_price ?? product.price)}</span>
                            </article>
                        `).join('')}
                    </div>
                </div>
            </div>
        `;
    } else {
        const total = state.cart.reduce((sum, item) => sum + item.final_price * item.qty, 0);
        bagHeading.textContent = `Tiene ${totalItems} articulo${totalItems === 1 ? '' : 's'} en su bolsa`;
        bagContent.innerHTML = `
            <div class="bag-filled-layout">
                <div class="bag-item-list">
                    ${state.cart.map((item) => `
                        <article class="bag-line">
                            <img src="${item.image}" alt="${item.name}">
                            <div>
                                <strong>${item.name}</strong>
                                <p>${item.category}</p>
                                <p>Talla: ${item.size || state.selectedSize}</p>
                                <span>Cantidad: ${item.qty}</span>
                                <button class="bag-remove" type="button" data-remove-id="${item.id}">Eliminar</button>
                            </div>
                            <strong>${formatCurrency(item.final_price * item.qty)}</strong>
                        </article>
                    `).join('')}
                </div>
                <aside class="bag-summary-card">
                    <div class="bag-summary-row"><span>Subtotal</span><strong>${formatCurrency(total)}</strong></div>
                    <div class="bag-summary-row"><span>Envio</span><strong>Gratis</strong></div>
                    <div class="bag-summary-row total-row"><span>Total estimado</span><strong>${formatCurrency(total)}</strong></div>
                    <div class="bag-summary-actions">
                        <a class="dialog-button primary-dialog" href="${backendBase}/checkout" target="_blank" rel="noreferrer" data-bridge-target="checkout">Continuar compra</a>
                    </div>
                </aside>
            </div>
        `;
    }

    bindProductCards(bagContent);
};

const categoryCard = (item, index) => `
    <article class="category-card tone-${(index % 4) + 1}" data-open-product="${item.id}">
        <div class="category-image-wrap">
            <img src="${item.image}" alt="${item.name}">
        </div>
        <div class="category-caption">
            <strong>${item.category}</strong>
            <span>${item.name}</span>
        </div>
    </article>
`;

const featuredCard = (product) => `
    <article class="feature-card" data-open-product="${product.id}">
        <img src="${product.image}" alt="${product.name}">
        <div class="feature-card-copy">
            <span>${product.category}</span>
            <h3>${product.name}</h3>
            <p>${product.description}</p>
            <strong>${formatCurrency(product.final_price ?? product.price)}</strong>
            <button class="card-action" data-add-id="${product.id}">Agregar a bolsa</button>
        </div>
    </article>
`;

const latestCard = (product) => `
    <article class="latest-card" data-open-product="${product.id}">
        <img src="${product.image}" alt="${product.name}">
        <div class="latest-card-copy">
            <span>${product.category}</span>
            <h3>${product.name}</h3>
            <strong>${formatCurrency(product.final_price ?? product.price)}</strong>
            <button class="card-action" data-add-id="${product.id}">Agregar</button>
        </div>
    </article>
`;

const promotionCard = (promotion, index) => `
    <article class="promotion-card promotion-card-${(index % 3) + 1}">
        <div class="promotion-image" style="${promotion.hero_image ? `background-image: linear-gradient(180deg, rgba(0,0,0,.08), rgba(0,0,0,.52)), url('${promotion.hero_image}')` : ''}">
            <span>${promotion.badge_text || 'Campana'}</span>
        </div>
        <div class="promotion-copy">
            <span>${promotion.discount_label}</span>
            <h3>${promotion.title}</h3>
            <p>${promotion.description || promotion.target_label}</p>
            <div class="promotion-meta">
                <strong>${promotion.code ? `Codigo ${promotion.code}` : 'Sin codigo requerido'}</strong>
                <small>${promotion.target_label}</small>
            </div>
        </div>
    </article>
`;

const pickDiverseProducts = (products, limit = 4) => {
    const pool = Array.isArray(products) ? products : [];
    const uniqueByCategory = [];
    const seenCategories = new Set();

    pool.forEach((product) => {
        const categoryKey = String(product.category || '').trim().toLowerCase();

        if (uniqueByCategory.length >= limit || seenCategories.has(categoryKey)) {
            return;
        }

        seenCategories.add(categoryKey);
        uniqueByCategory.push(product);
    });

    if (uniqueByCategory.length >= limit) {
        return uniqueByCategory.slice(0, limit);
    }

    const usedIds = new Set(uniqueByCategory.map((product) => product.id));
    const remaining = pool.filter((product) => !usedIds.has(product.id));

    return [...uniqueByCategory, ...remaining].slice(0, limit);
};

const excludeProductsById = (products, excludedIds) => {
    const blocked = new Set(excludedIds);

    return (Array.isArray(products) ? products : []).filter((product) => !blocked.has(product.id));
};

const pickProductsByName = (products, names) => {
    const wanted = new Set((Array.isArray(names) ? names : []).map((name) => String(name).trim().toLowerCase()));

    return (Array.isArray(products) ? products : []).filter((product) =>
        wanted.has(String(product.name || '').trim().toLowerCase())
    );
};

const searchCard = (product) => `
    <article class="search-card" data-open-product="${product.id}">
        <img src="${product.image}" alt="${product.name}">
        <div>
            <span>${product.category}</span>
            <strong>${product.name}</strong>
            <p>${formatCurrency(product.final_price ?? product.price)}</p>
        </div>
        <button class="card-action" data-add-id="${product.id}">Agregar</button>
    </article>
`;

const bindAddButtons = (scope = document) => {
    scope.querySelectorAll('[data-add-id]').forEach((button) => {
        button.addEventListener('click', (event) => {
            event.stopPropagation();
            addToBag(Number(button.dataset.addId));
        });
    });
};

const bindProductCards = (scope = document) => {
    scope.querySelectorAll('[data-open-product]').forEach((card) => {
        card.addEventListener('click', () => openProductDetail(Number(card.dataset.openProduct)));
    });
};

const renderSearchResults = (term = '') => {
    const normalized = term.trim().toLowerCase();
    const results = normalized
        ? state.products.filter((product) => [product.name, product.category, product.description].some((value) => value.toLowerCase().includes(normalized)))
        : state.products.slice(0, 6);

    document.querySelector('#search-meta').textContent = `${results.length} resultado${results.length === 1 ? '' : 's'} encontrados`;
    searchResults.innerHTML = results.map(searchCard).join('');
    bindProductCards(searchResults);
    bindAddButtons(searchResults);
};

document.querySelectorAll('[data-panel-target]').forEach((button) => {
    button.addEventListener('click', () => {
        if (button.dataset.panelTarget === 'bag') {
            renderBag();
        }
        openPanel(button.dataset.panelTarget);
    });
});

document.querySelectorAll('[data-close-panel]').forEach((button) => button.addEventListener('click', closePanels));
document.querySelector('[data-open-bag]')?.addEventListener('click', () => {
    renderBag();
    openPanel('bag');
});
overlay.addEventListener('click', closePanels);
searchInput.addEventListener('input', (event) => renderSearchResults(event.target.value));
document.querySelectorAll('[data-search-term]').forEach((button) => {
    button.addEventListener('click', () => {
        searchInput.value = button.dataset.searchTerm;
        renderSearchResults(button.dataset.searchTerm);
    });
});

document.addEventListener('click', (event) => {
    const homeLink = event.target.closest('a[data-go-home]');
    if (homeLink) {
        event.preventDefault();
        state.activeProductId = null;
        closePanels();
        window.scrollTo(0, 0);
        return;
    }

    const removeButton = event.target.closest('button[data-remove-id]');
    if (removeButton) {
        event.preventDefault();
        event.stopPropagation();
        removeFromBag(Number(removeButton.dataset.removeId));
        return;
    }

    const link = event.target.closest('a[data-bridge-target]');
    if (!link) return;
    event.preventDefault();
    openBackendWithCart(link.dataset.bridgeTarget, link.href);
});

document.querySelectorAll('.size-option').forEach((button) => {
    button.addEventListener('click', () => {
        document.querySelectorAll('.size-option').forEach((node) => node.classList.remove('active-size'));
        button.classList.add('active-size');
        state.selectedSize = button.textContent.trim();

        if (state.activeProductId) {
            openProductDetail(state.activeProductId);
        } else {
            closePanels();
        }
    });
});

fetch(`${apiBase}/storefront/overview`)
    .then(async (response) => {
        if (!response.ok) throw new Error('No se pudo cargar la tienda en este momento.');
        return response.json();
    })
    .then((data) => {
        const allProducts = data.allProducts?.length
            ? data.allProducts
            : [...data.featuredProducts, ...data.latestProducts]
                .filter((product, index, array) => array.findIndex((item) => item.id === product.id) === index);

        const pinnedMainSelectionNames = ['Jogger Street Move', 'Zapatillas Retro Pulse'];
        const pinnedMainSelection = pickProductsByName(allProducts, pinnedMainSelectionNames);
        const pinnedMainSelectionIds = pinnedMainSelection.map((product) => product.id);

        state.products = allProducts;

        const heroProducts = pickDiverseProducts(
            excludeProductsById(allProducts, pinnedMainSelectionIds),
            4
        );
        const heroProductIds = heroProducts.map((product) => product.id);
        const featuredProducts = [
            ...pinnedMainSelection,
            ...excludeProductsById(data.featuredProducts, [...heroProductIds, ...pinnedMainSelectionIds]),
        ].filter((product, index, array) => array.findIndex((item) => item.id === product.id) === index);
        const featuredProductIds = featuredProducts.map((product) => product.id);
        const latestProducts = excludeProductsById(allProducts, [...heroProductIds, ...featuredProductIds]);

        const visualFeature = data.featuredProducts[0] || data.latestProducts[0];
        if (visualFeature) {
            const layeredBackground = `
                linear-gradient(180deg, rgba(35, 24, 18, 0.24) 0%, rgba(18, 12, 8, 0.74) 100%),
                url('${visualFeature.image}')
            `;
            [contactVisual, menuVisual, accountVisual].forEach((node) => {
                node.style.backgroundImage = layeredBackground;
            });
        }

        categoryGrid.innerHTML = heroProducts.length
            ? heroProducts.map(categoryCard).join('')
            : '<div class="category-placeholder">No hay productos disponibles en este momento.</div>';
        backendStats.innerHTML = `
            <article class="stat-card"><span>Productos</span><strong>${data.stats.products}</strong></article>
            <article class="stat-card"><span>Destacados</span><strong>${data.stats.featured}</strong></article>
            <article class="stat-card"><span>Categorias</span><strong>${data.stats.categories}</strong></article>
            <article class="stat-card"><span>Stock</span><strong>${data.stats.stock}</strong></article>
        `;
        featuredGrid.innerHTML = featuredProducts.length
            ? featuredProducts.map(featuredCard).join('')
            : '<div class="product-loading">No hay productos destacados adicionales disponibles.</div>';
        promotionsGrid.innerHTML = data.promotions?.length
            ? data.promotions.map(promotionCard).join('')
            : '<div class="product-loading">Crea promociones desde el administrador para destacarlas aqui.</div>';
        latestGrid.innerHTML = latestProducts.length
            ? latestProducts.map(latestCard).join('')
            : '<div class="product-loading">No hay productos disponibles en este momento.</div>';

        bindProductCards(categoryGrid);
        bindProductCards(featuredGrid);
        bindProductCards(latestGrid);
        bindAddButtons(featuredGrid);
        bindAddButtons(latestGrid);
        renderSearchResults();
        renderBag();
    })
    .catch((error) => {
        categoryGrid.innerHTML = `<div class="category-placeholder">${error.message}</div>`;
        backendStats.innerHTML = `<div class="stat-card muted-card">${error.message}</div>`;
        featuredGrid.innerHTML = `<div class="product-loading">${error.message}</div>`;
        promotionsGrid.innerHTML = `<div class="product-loading">${error.message}</div>`;
        latestGrid.innerHTML = `<div class="product-loading">${error.message}</div>`;
    });
