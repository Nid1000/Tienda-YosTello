(function(){const e=document.createElement("link").relList;if(e&&e.supports&&e.supports("modulepreload"))return;for(const s of document.querySelectorAll('link[rel="modulepreload"]'))r(s);new MutationObserver(s=>{for(const n of s)if(n.type==="childList")for(const l of n.addedNodes)l.tagName==="LINK"&&l.rel==="modulepreload"&&r(l)}).observe(document,{childList:!0,subtree:!0});function t(s){const n={};return s.integrity&&(n.integrity=s.integrity),s.referrerPolicy&&(n.referrerPolicy=s.referrerPolicy),s.crossOrigin==="use-credentials"?n.credentials="include":s.crossOrigin==="anonymous"?n.credentials="omit":n.credentials="same-origin",n}function r(s){if(s.ep)return;s.ep=!0;const n=t(s);fetch(s.href,n)}})();var O,I;const K=(I=(O=import.meta)==null?void 0:O.env)==null?void 0:I.VITE_API_BASE_URL;var x;const X=(x=document.querySelector('meta[name="api-base-url"]'))==null?void 0:x.getAttribute("content"),F=(K||X||"http://127.0.0.1:8000/api").replace(/\/$/,""),o=F.replace(/\/api$/,"");var B,N;const f=(N=(B=document.querySelector('meta[name="auth-user-initial"]'))==null?void 0:B.getAttribute("content"))==null?void 0:N.trim();var H,D;const Z=(D=(H=document.querySelector('meta[name="auth-user-name"]'))==null?void 0:H.getAttribute("content"))==null?void 0:D.trim();var j;const Q=((j=document.querySelector('meta[name="logout-url"]'))==null?void 0:j.getAttribute("content"))||`${o}/logout`;var R;const aa=((R=document.querySelector('meta[name="csrf-token"]'))==null?void 0:R.getAttribute("content"))||"",ea=document.querySelector("#app"),ta=f?`<button class="topbar-action account-action" data-panel-target="account"><span class="account-initial-badge">${f.slice(0,1).toUpperCase()}</span><span>Cuenta</span></button>`:'<button class="topbar-action" data-panel-target="account">Cuenta</button>',sa=f?`
        <div class="account-user-card">
            <span class="account-initial-large">${f.slice(0,1).toUpperCase()}</span>
            <div>
                <strong>${Z||"Mi cuenta"}</strong>
                <small>Sesion iniciada</small>
            </div>
        </div>
        <a href="${o}/pedidos">Mis pedidos</a>
        <a href="${o}/dashboard">Mi cuenta</a>
        <form class="account-logout-form" method="POST" action="${Q}">
            <input type="hidden" name="_token" value="${aa}">
            <button type="submit">Cerrar sesion</button>
        </form>
    `:`
        <a href="${o}/login" data-bridge-target="cart">Iniciar sesion</a>
        <a href="${o}/registro">Crear cuenta</a>
    `;ea.innerHTML=`
    <div class="page-shell">
        <div class="topbar">
            <button class="topbar-contact" data-panel-target="contact">+ Pongase en contacto con nosotros</button>
            <a class="topbar-brand" href="#" data-go-home>YO-TELLO</a>
            <div class="topbar-right">
                ${ta}
                <a class="topbar-action" href="${o}/productos">Buscar</a>
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
                    <a class="dialog-button primary-dialog" href="${o}/checkout" target="_blank" rel="noreferrer" data-bridge-target="checkout">Finalizar la compra</a>
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
                    ${sa}
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
                        <a href="${o}/productos" target="_blank" rel="noreferrer">Novedades</a>
                        <a href="${o}/productos?category=ropa" target="_blank" rel="noreferrer">Ropa</a>
                        <a href="${o}/productos?category=zapatillas" target="_blank" rel="noreferrer">Zapatillas</a>
                        <a href="${o}/productos?category=accesorios" target="_blank" rel="noreferrer">Accesorios</a>
                        <a href="${o}/productos?category=bolsos" target="_blank" rel="noreferrer">Bolsos</a>
                    </nav>
                    <div class="menu-secondary">
                        <a href="${o}/productos" target="_blank" rel="noreferrer">Catalogo completo</a>
                        <a href="${o}/admin" target="_blank" rel="noreferrer">Administrador</a>
                        <a href="${o}/login" target="_blank" rel="noreferrer" data-bridge-target="cart">Iniciar sesion</a>
                        <a href="${o}/pedidos" target="_blank" rel="noreferrer">Mis pedidos</a>
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
                            <a href="${o}/productos" target="_blank" rel="noreferrer">Catalogo completo</a>
                            <a href="${o}/admin" target="_blank" rel="noreferrer">Panel admin</a>
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
                            <a class="campaign-button bag-primary-link" href="${o}/productos" target="_blank" rel="noreferrer">Seguir comprando</a>
                            <a class="bag-secondary-link" href="${o}/checkout" target="_blank" rel="noreferrer">Ir a checkout</a>
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
                    <a class="campaign-button" href="${o}/admin/promociones" target="_blank" rel="noreferrer">Administrar promociones</a>
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
                            style="background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.08), rgba(0, 0, 0, 0.28)), url('${o}/services/appointment.jpg');"
                        ></div>
                        <strong>Reservar cita</strong>
                        <p>Atencion personalizada para elegir piezas, tallas y combinaciones con calma.</p>
                        <a href="mailto:hola@yotello.com" target="_blank" rel="noreferrer">Reservar ahora</a>
                    </article>
                    <article class="service-card">
                        <div
                            class="service-image"
                            style="background-image: linear-gradient(180deg, rgba(61, 32, 0, 0.12), rgba(61, 32, 0, 0.34)), url('${o}/services/personalization.jpg');"
                        ></div>
                        <strong>Personalizacion</strong>
                        <p>Detalles especiales, empaques cuidados y una experiencia mas exclusiva.</p>
                        <a href="${o}/productos" target="_blank" rel="noreferrer">Descubrir</a>
                    </article>
                    <article class="service-card">
                        <div
                            class="service-image"
                            style="background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.08), rgba(0, 0, 0, 0.24)), url('${o}/services/pickup.jpg');"
                        ></div>
                        <strong>Recogida en tienda</strong>
                        <p>Compra online y recoge tu pedido en el punto que prefieras.</p>
                        <a href="${o}/checkout" target="_blank" rel="noreferrer">Como funciona</a>
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
                        <a href="${o}/pedidos" target="_blank" rel="noreferrer">Mi pedido</a>
                        <a href="${o}/productos" target="_blank" rel="noreferrer">Mapa del sitio</a>
                    </div>
                    <div>
                        <h3>Empresa</h3>
                        <a href="${o}/admin" target="_blank" rel="noreferrer">Panel administrador</a>
                        <a href="${o}/productos" target="_blank" rel="noreferrer">Colecciones</a>
                        <a href="${o}/login" target="_blank" rel="noreferrer" data-bridge-target="cart">Iniciar sesion</a>
                    </div>
                    <div>
                        <h3>Servicios</h3>
                        <a href="mailto:hola@yotello.com">Reservar cita</a>
                        <a href="${o}/checkout" target="_blank" rel="noreferrer">Checkout</a>
                        <a href="${o}/carrito" target="_blank" rel="noreferrer">Bolsa</a>
                    </div>
                </div>
                <div class="footer-mark">
                    <span class="footer-mark-symbol">YT</span>
                    <strong>YO-TELLO</strong>
                </div>
            </footer>
        </main>
    </div>
`;const z=document.querySelector("#overlay"),ra=document.querySelector("#contact-visual"),oa=document.querySelector("#menu-visual"),ca=document.querySelector("#account-visual"),L=document.querySelector("#category-grid"),T=document.querySelector("#backend-stats"),h=document.querySelector("#featured-grid"),E=document.querySelector("#promotions-grid"),b=document.querySelector("#latest-grid"),A=document.querySelector("#bag-count"),C=document.querySelector("#bag-content"),w=document.querySelector("#bag-heading"),V=document.querySelector("#search-input"),q=document.querySelector("#search-results"),y=document.querySelector("#product-detail"),na=document.querySelector("#cart-dialog-body"),c={products:[],cart:JSON.parse(localStorage.getItem("yotello-cart")||"[]"),selectedSize:"M / 40",activeProductId:null};c.cart=(Array.isArray(c.cart)?c.cart:[]).map(a=>({...a,size:(a==null?void 0:a.size)||"M / 40"}));const d=a=>new Intl.NumberFormat("es-CO",{style:"currency",currency:"COP",maximumFractionDigits:0}).format(a||0),G=()=>localStorage.setItem("yotello-cart",JSON.stringify(c.cart)),ia=a=>{c.cart=c.cart.filter(e=>e.id!==a),G(),v()},da=(a,e)=>{if(!c.cart.length){window.open(e,"_blank","noopener,noreferrer");return}const t=document.createElement("form");t.method="POST",t.action=`${o}/bridge/cart`,t.target="_blank",t.style.display="none";const r=document.createElement("input");r.type="hidden",r.name="target",r.value=a;const s=document.createElement("input");s.type="hidden",s.name="cart",s.value=JSON.stringify(c.cart.map(n=>({id:n.id,qty:n.qty,size:n.size||c.selectedSize}))),t.appendChild(r),t.appendChild(s),document.body.appendChild(t),t.submit(),t.remove()},m=a=>{var e;document.querySelectorAll(".contact-panel, .account-panel, .menu-panel, .search-panel, .product-panel, .bag-view, .size-panel, .cart-dialog").forEach(t=>t.classList.add("hidden")),z.classList.remove("hidden"),(e=document.querySelector(`#${a}-panel, #${a}`))==null||e.classList.remove("hidden")},k=()=>{document.querySelectorAll(".contact-panel, .account-panel, .menu-panel, .search-panel, .product-panel, .bag-view, .size-panel, .cart-dialog").forEach(a=>a.classList.add("hidden")),z.classList.add("hidden")},U=a=>{var r;const e=c.products.find(s=>s.id===a);if(!e)return;c.activeProductId=a;const t=c.products.filter(s=>s.category===e.category).slice(0,4);y.innerHTML=`
        <div class="product-hero">
            <div class="product-hero-image">
                <img src="${e.image}" alt="${e.name}">
            </div>
            <div class="product-thumb-row">
                ${(t.length?t:[e]).map(s=>`
                    <button class="product-thumb ${s.id===e.id?"active-thumb":""}" data-open-product="${s.id}">
                        <img src="${s.image}" alt="${s.name}">
                    </button>
                `).join("")}
            </div>
        </div>
        <div class="product-content">
            <div class="product-copy-area">
                <span class="product-category">${e.category}</span>
                <h2>${e.name}</h2>
                <strong class="product-price">${d(e.final_price??e.price)}</strong>
                <p class="product-description">${e.description}</p>
                <div class="product-size-row">
                    <span>Talla: ${c.selectedSize}</span>
                    <button class="product-plus" data-open-size type="button">+</button>
                </div>
                <div class="product-accordion">
                    <button type="button">Detalles del producto</button>
                    <button type="button">Materiales y cuidado</button>
                    <button type="button">Nuestro compromiso</button>
                </div>
            </div>
            <aside class="product-side">
                <button class="product-buy" data-add-id="${e.id}">Anadir a la bolsa de compras</button>
                <a class="product-window-link" href="${o}/productos" target="_blank" rel="noreferrer">Ver catalogo completo</a>
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
    `,p(y),$(y),(r=y.querySelector("[data-open-size]"))==null||r.addEventListener("click",()=>m("size")),m("product")},la=a=>{na.innerHTML=`
        <img src="${a.image}" alt="${a.name}">
        <div>
            <strong>${a.name}</strong>
            <p>${d(a.final_price??a.price)}</p>
            <span>Categoria: ${a.category}</span>
        </div>
    `,m("cart-dialog")},ua=a=>{const e=c.products.find(r=>r.id===a);if(!e)return;const t=c.cart.find(r=>r.id===a);t?(t.qty+=1,t.size=t.size||c.selectedSize):c.cart.push({id:e.id,name:e.name,category:e.category,image:e.image,final_price:e.final_price??e.price,qty:1,size:c.selectedSize}),G(),v(),la(e)},v=()=>{const a=c.cart.reduce((e,t)=>e+t.qty,0);if(A&&(A.textContent=String(a)),c.cart.length===0)w.textContent="Su bolsa de compra esta actualmente vacia",C.innerHTML=`
            <div class="bag-empty-layout">
                <div class="bag-empty-visual"></div>
                <div class="bag-recommendations">
                    <h3>Quizas tambien le guste</h3>
                    <div class="bag-product-strip">
                        ${c.products.slice(0,4).map(e=>`
                            <article class="bag-suggestion" data-open-product="${e.id}">
                                <img src="${e.image}" alt="${e.name}">
                                <strong>${e.name}</strong>
                                <span>${d(e.final_price??e.price)}</span>
                            </article>
                        `).join("")}
                    </div>
                </div>
            </div>
        `;else{const e=c.cart.reduce((t,r)=>t+r.final_price*r.qty,0);w.textContent=`Tiene ${a} articulo${a===1?"":"s"} en su bolsa`,C.innerHTML=`
            <div class="bag-filled-layout">
                <div class="bag-item-list">
                    ${c.cart.map(t=>`
                        <article class="bag-line">
                            <img src="${t.image}" alt="${t.name}">
                            <div>
                                <strong>${t.name}</strong>
                                <p>${t.category}</p>
                                <p>Talla: ${t.size||c.selectedSize}</p>
                                <span>Cantidad: ${t.qty}</span>
                                <button class="bag-remove" type="button" data-remove-id="${t.id}">Eliminar</button>
                            </div>
                            <strong>${d(t.final_price*t.qty)}</strong>
                        </article>
                    `).join("")}
                </div>
                <aside class="bag-summary-card">
                    <div class="bag-summary-row"><span>Subtotal</span><strong>${d(e)}</strong></div>
                    <div class="bag-summary-row"><span>Envio</span><strong>Gratis</strong></div>
                    <div class="bag-summary-row total-row"><span>Total estimado</span><strong>${d(e)}</strong></div>
                    <div class="bag-summary-actions">
                        <a class="dialog-button primary-dialog" href="${o}/checkout" target="_blank" rel="noreferrer" data-bridge-target="checkout">Continuar compra</a>
                    </div>
                </aside>
            </div>
        `}p(C)},pa=(a,e)=>`
    <article class="category-card tone-${e%4+1}" data-open-product="${a.id}">
        <div class="category-image-wrap">
            <img src="${a.image}" alt="${a.name}">
        </div>
        <div class="category-caption">
            <strong>${a.category}</strong>
            <span>${a.name}</span>
        </div>
    </article>
`,ga=a=>`
    <article class="feature-card" data-open-product="${a.id}">
        <img src="${a.image}" alt="${a.name}">
        <div class="feature-card-copy">
            <span>${a.category}</span>
            <h3>${a.name}</h3>
            <p>${a.description}</p>
            <strong>${d(a.final_price??a.price)}</strong>
            <button class="card-action" data-add-id="${a.id}">Agregar a bolsa</button>
        </div>
    </article>
`,ma=a=>`
    <article class="latest-card" data-open-product="${a.id}">
        <img src="${a.image}" alt="${a.name}">
        <div class="latest-card-copy">
            <span>${a.category}</span>
            <h3>${a.name}</h3>
            <strong>${d(a.final_price??a.price)}</strong>
            <button class="card-action" data-add-id="${a.id}">Agregar</button>
        </div>
    </article>
`,va=(a,e)=>`
    <article class="promotion-card promotion-card-${e%3+1}">
        <div class="promotion-image" style="${a.hero_image?`background-image: linear-gradient(180deg, rgba(0,0,0,.08), rgba(0,0,0,.52)), url('${a.hero_image}')`:""}">
            <span>${a.badge_text||"Campana"}</span>
        </div>
        <div class="promotion-copy">
            <span>${a.discount_label}</span>
            <h3>${a.title}</h3>
            <p>${a.description||a.target_label}</p>
            <div class="promotion-meta">
                <strong>${a.code?`Codigo ${a.code}`:"Sin codigo requerido"}</strong>
                <small>${a.target_label}</small>
            </div>
        </div>
    </article>
`,ha=(a,e=4)=>{const t=Array.isArray(a)?a:[],r=[],s=new Set;if(t.forEach(i=>{const g=String(i.category||"").trim().toLowerCase();r.length>=e||s.has(g)||(s.add(g),r.push(i))}),r.length>=e)return r.slice(0,e);const n=new Set(r.map(i=>i.id)),l=t.filter(i=>!n.has(i.id));return[...r,...l].slice(0,e)},M=(a,e)=>{const t=new Set(e);return(Array.isArray(a)?a:[]).filter(r=>!t.has(r.id))},ba=a=>`
    <article class="search-card" data-open-product="${a.id}">
        <img src="${a.image}" alt="${a.name}">
        <div>
            <span>${a.category}</span>
            <strong>${a.name}</strong>
            <p>${d(a.final_price??a.price)}</p>
        </div>
        <button class="card-action" data-add-id="${a.id}">Agregar</button>
    </article>
`,$=(a=document)=>{a.querySelectorAll("[data-add-id]").forEach(e=>{e.addEventListener("click",t=>{t.stopPropagation(),ua(Number(e.dataset.addId))})})},p=(a=document)=>{a.querySelectorAll("[data-open-product]").forEach(e=>{e.addEventListener("click",()=>U(Number(e.dataset.openProduct)))})},_=(a="")=>{const e=a.trim().toLowerCase(),t=e?c.products.filter(r=>[r.name,r.category,r.description].some(s=>s.toLowerCase().includes(e))):c.products.slice(0,6);document.querySelector("#search-meta").textContent=`${t.length} resultado${t.length===1?"":"s"} encontrados`,q.innerHTML=t.map(ba).join(""),p(q),$(q)};document.querySelectorAll("[data-panel-target]").forEach(a=>{a.addEventListener("click",()=>{a.dataset.panelTarget==="bag"&&v(),m(a.dataset.panelTarget)})});document.querySelectorAll("[data-close-panel]").forEach(a=>a.addEventListener("click",k));var Y;(Y=document.querySelector("[data-open-bag]"))==null||Y.addEventListener("click",()=>{v(),m("bag")});z.addEventListener("click",k);V.addEventListener("input",a=>_(a.target.value));document.querySelectorAll("[data-search-term]").forEach(a=>{a.addEventListener("click",()=>{V.value=a.dataset.searchTerm,_(a.dataset.searchTerm)})});document.addEventListener("click",a=>{if(a.target.closest("a[data-go-home]")){a.preventDefault(),c.activeProductId=null,k(),window.scrollTo(0,0);return}const t=a.target.closest("button[data-remove-id]");if(t){a.preventDefault(),a.stopPropagation(),ia(Number(t.dataset.removeId));return}const r=a.target.closest("a[data-bridge-target]");r&&(a.preventDefault(),da(r.dataset.bridgeTarget,r.href))});document.querySelectorAll(".size-option").forEach(a=>{a.addEventListener("click",()=>{document.querySelectorAll(".size-option").forEach(e=>e.classList.remove("active-size")),a.classList.add("active-size"),c.selectedSize=a.textContent.trim(),c.activeProductId?U(c.activeProductId):k()})});fetch(`${F}/storefront/overview`).then(async a=>{if(!a.ok)throw new Error("No se pudo cargar la tienda en este momento.");return a.json()}).then(a=>{var g,P;const e=(g=a.allProducts)!=null&&g.length?a.allProducts:[...a.featuredProducts,...a.latestProducts].filter((u,S,J)=>J.findIndex(W=>W.id===u.id)===S);c.products=e;const t=ha(e,4),r=t.map(u=>u.id),s=M(a.featuredProducts,r),n=s.map(u=>u.id),l=M(e,[...r,...n]),i=a.featuredProducts[0]||a.latestProducts[0];if(i){const u=`
                linear-gradient(180deg, rgba(35, 24, 18, 0.24) 0%, rgba(18, 12, 8, 0.74) 100%),
                url('${i.image}')
            `;[ra,oa,ca].forEach(S=>{S.style.backgroundImage=u})}L.innerHTML=t.length?t.map(pa).join(""):'<div class="category-placeholder">No hay productos disponibles en este momento.</div>',T.innerHTML=`
            <article class="stat-card"><span>Productos</span><strong>${a.stats.products}</strong></article>
            <article class="stat-card"><span>Destacados</span><strong>${a.stats.featured}</strong></article>
            <article class="stat-card"><span>Categorias</span><strong>${a.stats.categories}</strong></article>
            <article class="stat-card"><span>Stock</span><strong>${a.stats.stock}</strong></article>
        `,h.innerHTML=s.length?s.map(ga).join(""):'<div class="product-loading">No hay productos destacados adicionales disponibles.</div>',E.innerHTML=(P=a.promotions)!=null&&P.length?a.promotions.map(va).join(""):'<div class="product-loading">Crea promociones desde el administrador para destacarlas aqui.</div>',b.innerHTML=l.length?l.map(ma).join(""):'<div class="product-loading">No hay productos disponibles en este momento.</div>',p(L),p(h),p(b),$(h),$(b),_(),v()}).catch(a=>{L.innerHTML=`<div class="category-placeholder">${a.message}</div>`,T.innerHTML=`<div class="stat-card muted-card">${a.message}</div>`,h.innerHTML=`<div class="product-loading">${a.message}</div>`,E.innerHTML=`<div class="product-loading">${a.message}</div>`,b.innerHTML=`<div class="product-loading">${a.message}</div>`});
