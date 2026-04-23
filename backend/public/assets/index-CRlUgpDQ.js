(function(){const e=document.createElement("link").relList;if(e&&e.supports&&e.supports("modulepreload"))return;for(const s of document.querySelectorAll('link[rel="modulepreload"]'))c(s);new MutationObserver(s=>{for(const i of s)if(i.type==="childList")for(const d of i.addedNodes)d.tagName==="LINK"&&d.rel==="modulepreload"&&c(d)}).observe(document,{childList:!0,subtree:!0});function t(s){const i={};return s.integrity&&(i.integrity=s.integrity),s.referrerPolicy&&(i.referrerPolicy=s.referrerPolicy),s.crossOrigin==="use-credentials"?i.credentials="include":s.crossOrigin==="anonymous"?i.credentials="omit":i.credentials="same-origin",i}function c(s){if(s.ep)return;s.ep=!0;const i=t(s);fetch(s.href,i)}})();var T,E;const R=(E=(T=import.meta)==null?void 0:T.env)==null?void 0:E.VITE_API_BASE_URL;var P;const Y=(P=document.querySelector('meta[name="api-base-url"]'))==null?void 0:P.getAttribute("content"),H=(R||Y||"http://127.0.0.1:8000/api").replace(/\/$/,""),r=H.replace(/\/api$/,"");var A,M;const b=(M=(A=document.querySelector('meta[name="auth-user-initial"]'))==null?void 0:A.getAttribute("content"))==null?void 0:M.trim();var O,w;const F=(w=(O=document.querySelector('meta[name="auth-user-name"]'))==null?void 0:O.getAttribute("content"))==null?void 0:w.trim();var x;const V=((x=document.querySelector('meta[name="logout-url"]'))==null?void 0:x.getAttribute("content"))||`${r}/logout`;var I;const G=((I=document.querySelector('meta[name="csrf-token"]'))==null?void 0:I.getAttribute("content"))||"",U=document.querySelector("#app"),J=b?`<button class="topbar-action account-action" data-panel-target="account"><span class="account-initial-badge">${b.slice(0,1).toUpperCase()}</span><span>Cuenta</span></button>`:'<button class="topbar-action" data-panel-target="account">Cuenta</button>',W=b?`
        <div class="account-user-card">
            <span class="account-initial-large">${b.slice(0,1).toUpperCase()}</span>
            <div>
                <strong>${F||"Mi cuenta"}</strong>
                <small>Sesion iniciada</small>
            </div>
        </div>
        <a href="${r}/pedidos">Mis pedidos</a>
        <a href="${r}/dashboard">Mi cuenta</a>
        <form class="account-logout-form" method="POST" action="${V}">
            <input type="hidden" name="_token" value="${G}">
            <button type="submit">Cerrar sesion</button>
        </form>
    `:`
        <a href="${r}/login" data-bridge-target="cart">Iniciar sesion</a>
        <a href="${r}/registro">Crear cuenta</a>
    `;U.innerHTML=`
    <div class="page-shell">
        <div class="topbar">
            <button class="topbar-contact" data-panel-target="contact">+ Pongase en contacto con nosotros</button>
            <a class="topbar-brand" href="#" data-go-home>YO-TELLO</a>
            <div class="topbar-right">
                ${J}
                <a class="topbar-action" href="${r}/productos">Buscar</a>
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
                    <a class="dialog-button primary-dialog" href="${r}/checkout" target="_blank" rel="noreferrer" data-bridge-target="checkout">Finalizar la compra</a>
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
                    ${W}
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
                        <a href="${r}/productos" target="_blank" rel="noreferrer">Novedades</a>
                        <a href="${r}/productos?category=ropa" target="_blank" rel="noreferrer">Ropa</a>
                        <a href="${r}/productos?category=zapatillas" target="_blank" rel="noreferrer">Zapatillas</a>
                        <a href="${r}/productos?category=accesorios" target="_blank" rel="noreferrer">Accesorios</a>
                        <a href="${r}/productos?category=bolsos" target="_blank" rel="noreferrer">Bolsos</a>
                    </nav>
                    <div class="menu-secondary">
                        <a href="${r}/productos" target="_blank" rel="noreferrer">Catalogo completo</a>
                        <a href="${r}/admin" target="_blank" rel="noreferrer">Administrador</a>
                        <a href="${r}/login" target="_blank" rel="noreferrer" data-bridge-target="cart">Iniciar sesion</a>
                        <a href="${r}/pedidos" target="_blank" rel="noreferrer">Mis pedidos</a>
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
                            <a href="${r}/productos" target="_blank" rel="noreferrer">Catalogo completo</a>
                            <a href="${r}/admin" target="_blank" rel="noreferrer">Panel admin</a>
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
                            <a class="campaign-button bag-primary-link" href="${r}/productos" target="_blank" rel="noreferrer">Seguir comprando</a>
                            <a class="bag-secondary-link" href="${r}/checkout" target="_blank" rel="noreferrer">Ir a checkout</a>
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
                    <a class="campaign-button" href="${r}/admin/promociones" target="_blank" rel="noreferrer">Administrar promociones</a>
                </div>
                <div id="promotions-grid" class="promotions-grid">
                    <div class="product-loading">Cargando promociones...</div>
                </div>
            </section>

            <section class="editorial-section latest-section" id="latest-products">
                <div class="section-copy dark-copy">
                    <p class="section-kicker">Novedades</p>
                    <h2>Ultimos ingresos</h2>
                </div>
                <div id="latest-grid" class="latest-grid">
                    <div class="product-loading">Cargando novedades...</div>
                </div>
            </section>

            <section class="luxury-services">
                <p class="section-kicker">Servicios YO-TELLO</p>
                <div class="service-grid">
                    <article class="service-card">
                        <div class="service-image service-image-dark"></div>
                        <strong>Reservar cita</strong>
                        <p>Atencion personalizada para elegir piezas, tallas y combinaciones con calma.</p>
                        <a href="mailto:hola@yotello.com" target="_blank" rel="noreferrer">Reservar ahora</a>
                    </article>
                    <article class="service-card">
                        <div class="service-image service-image-gold"></div>
                        <strong>Personalizacion</strong>
                        <p>Detalles especiales, empaques cuidados y una experiencia mas exclusiva.</p>
                        <a href="${r}/productos" target="_blank" rel="noreferrer">Descubrir</a>
                    </article>
                    <article class="service-card">
                        <div class="service-image service-image-stone"></div>
                        <strong>Recogida en tienda</strong>
                        <p>Compra online y recoge tu pedido en el punto que prefieras.</p>
                        <a href="${r}/checkout" target="_blank" rel="noreferrer">Como funciona</a>
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
                        <a href="${r}/pedidos" target="_blank" rel="noreferrer">Mi pedido</a>
                        <a href="${r}/productos" target="_blank" rel="noreferrer">Mapa del sitio</a>
                    </div>
                    <div>
                        <h3>Empresa</h3>
                        <a href="${r}/admin" target="_blank" rel="noreferrer">Panel administrador</a>
                        <a href="${r}/productos" target="_blank" rel="noreferrer">Colecciones</a>
                        <a href="${r}/login" target="_blank" rel="noreferrer" data-bridge-target="cart">Iniciar sesion</a>
                    </div>
                    <div>
                        <h3>Servicios</h3>
                        <a href="mailto:hola@yotello.com">Reservar cita</a>
                        <a href="${r}/checkout" target="_blank" rel="noreferrer">Checkout</a>
                        <a href="${r}/carrito" target="_blank" rel="noreferrer">Bolsa</a>
                    </div>
                </div>
                <div class="footer-mark">
                    <span class="footer-mark-symbol">YT</span>
                    <strong>YO-TELLO</strong>
                </div>
            </footer>
        </main>
    </div>
`;const S=document.querySelector("#overlay"),X=document.querySelector("#contact-visual"),Z=document.querySelector("#menu-visual"),K=document.querySelector("#account-visual"),y=document.querySelector("#category-grid"),C=document.querySelector("#backend-stats"),g=document.querySelector("#featured-grid"),q=document.querySelector("#promotions-grid"),m=document.querySelector("#latest-grid"),z=document.querySelector("#bag-count"),$=document.querySelector("#bag-content"),_=document.querySelector("#bag-heading"),N=document.querySelector("#search-input"),k=document.querySelector("#search-results"),v=document.querySelector("#product-detail"),Q=document.querySelector("#cart-dialog-body"),o={products:[],cart:JSON.parse(localStorage.getItem("yotello-cart")||"[]"),selectedSize:"M / 40",activeProductId:null};o.cart=(Array.isArray(o.cart)?o.cart:[]).map(a=>({...a,size:(a==null?void 0:a.size)||"M / 40"}));const n=a=>new Intl.NumberFormat("es-CO",{style:"currency",currency:"COP",maximumFractionDigits:0}).format(a||0),D=()=>localStorage.setItem("yotello-cart",JSON.stringify(o.cart)),aa=a=>{o.cart=o.cart.filter(e=>e.id!==a),D(),p()},ea=(a,e)=>{if(!o.cart.length){window.open(e,"_blank","noopener,noreferrer");return}const t=document.createElement("form");t.method="POST",t.action=`${r}/bridge/cart`,t.target="_blank",t.style.display="none";const c=document.createElement("input");c.type="hidden",c.name="target",c.value=a;const s=document.createElement("input");s.type="hidden",s.name="cart",s.value=JSON.stringify(o.cart.map(i=>({id:i.id,qty:i.qty,size:i.size||o.selectedSize}))),t.appendChild(c),t.appendChild(s),document.body.appendChild(t),t.submit(),t.remove()},u=a=>{var e;document.querySelectorAll(".contact-panel, .account-panel, .menu-panel, .search-panel, .product-panel, .bag-view, .size-panel, .cart-dialog").forEach(t=>t.classList.add("hidden")),S.classList.remove("hidden"),(e=document.querySelector(`#${a}-panel, #${a}`))==null||e.classList.remove("hidden")},f=()=>{document.querySelectorAll(".contact-panel, .account-panel, .menu-panel, .search-panel, .product-panel, .bag-view, .size-panel, .cart-dialog").forEach(a=>a.classList.add("hidden")),S.classList.add("hidden")},j=a=>{var c;const e=o.products.find(s=>s.id===a);if(!e)return;o.activeProductId=a;const t=o.products.filter(s=>s.category===e.category).slice(0,4);v.innerHTML=`
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
                <strong class="product-price">${n(e.final_price??e.price)}</strong>
                <p class="product-description">${e.description}</p>
                <div class="product-size-row">
                    <span>Talla: ${o.selectedSize}</span>
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
                <a class="product-window-link" href="${r}/productos" target="_blank" rel="noreferrer">Ver catalogo completo</a>
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
    `,l(v),h(v),(c=v.querySelector("[data-open-size]"))==null||c.addEventListener("click",()=>u("size")),u("product")},ta=a=>{Q.innerHTML=`
        <img src="${a.image}" alt="${a.name}">
        <div>
            <strong>${a.name}</strong>
            <p>${n(a.final_price??a.price)}</p>
            <span>Categoria: ${a.category}</span>
        </div>
    `,u("cart-dialog")},sa=a=>{const e=o.products.find(c=>c.id===a);if(!e)return;const t=o.cart.find(c=>c.id===a);t?(t.qty+=1,t.size=t.size||o.selectedSize):o.cart.push({id:e.id,name:e.name,category:e.category,image:e.image,final_price:e.final_price??e.price,qty:1,size:o.selectedSize}),D(),p(),ta(e)},p=()=>{const a=o.cart.reduce((e,t)=>e+t.qty,0);if(z&&(z.textContent=String(a)),o.cart.length===0)_.textContent="Su bolsa de compra esta actualmente vacia",$.innerHTML=`
            <div class="bag-empty-layout">
                <div class="bag-empty-visual"></div>
                <div class="bag-recommendations">
                    <h3>Quizas tambien le guste</h3>
                    <div class="bag-product-strip">
                        ${o.products.slice(0,4).map(e=>`
                            <article class="bag-suggestion" data-open-product="${e.id}">
                                <img src="${e.image}" alt="${e.name}">
                                <strong>${e.name}</strong>
                                <span>${n(e.final_price??e.price)}</span>
                            </article>
                        `).join("")}
                    </div>
                </div>
            </div>
        `;else{const e=o.cart.reduce((t,c)=>t+c.final_price*c.qty,0);_.textContent=`Tiene ${a} articulo${a===1?"":"s"} en su bolsa`,$.innerHTML=`
            <div class="bag-filled-layout">
                <div class="bag-item-list">
                    ${o.cart.map(t=>`
                        <article class="bag-line">
                            <img src="${t.image}" alt="${t.name}">
                            <div>
                                <strong>${t.name}</strong>
                                <p>${t.category}</p>
                                <p>Talla: ${t.size||o.selectedSize}</p>
                                <span>Cantidad: ${t.qty}</span>
                                <button class="bag-remove" type="button" data-remove-id="${t.id}">Eliminar</button>
                            </div>
                            <strong>${n(t.final_price*t.qty)}</strong>
                        </article>
                    `).join("")}
                </div>
                <aside class="bag-summary-card">
                    <div class="bag-summary-row"><span>Subtotal</span><strong>${n(e)}</strong></div>
                    <div class="bag-summary-row"><span>Envio</span><strong>Gratis</strong></div>
                    <div class="bag-summary-row total-row"><span>Total estimado</span><strong>${n(e)}</strong></div>
                    <div class="bag-summary-actions">
                        <a class="dialog-button primary-dialog" href="${r}/checkout" target="_blank" rel="noreferrer" data-bridge-target="checkout">Continuar compra</a>
                        <a class="dialog-button secondary-dialog" href="${r}/carrito" target="_blank" rel="noreferrer" data-bridge-target="cart">Abrir carrito Laravel</a>
                    </div>
                </aside>
            </div>
        `}l($)},ra=(a,e)=>`
    <article class="category-card tone-${e%4+1}" data-open-product="${a.id}">
        <div class="category-image-wrap">
            <img src="${a.image}" alt="${a.name}">
        </div>
        <div class="category-caption">
            <strong>${a.category}</strong>
            <span>${a.name}</span>
        </div>
    </article>
`,oa=a=>`
    <article class="feature-card" data-open-product="${a.id}">
        <img src="${a.image}" alt="${a.name}">
        <div class="feature-card-copy">
            <span>${a.category}</span>
            <h3>${a.name}</h3>
            <p>${a.description}</p>
            <strong>${n(a.final_price??a.price)}</strong>
            <button class="card-action" data-add-id="${a.id}">Agregar a bolsa</button>
        </div>
    </article>
`,ca=a=>`
    <article class="latest-card" data-open-product="${a.id}">
        <img src="${a.image}" alt="${a.name}">
        <div class="latest-card-copy">
            <span>${a.category}</span>
            <h3>${a.name}</h3>
            <strong>${n(a.final_price??a.price)}</strong>
            <button class="card-action" data-add-id="${a.id}">Agregar</button>
        </div>
    </article>
`,ia=(a,e)=>`
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
`,na=a=>`
    <article class="search-card" data-open-product="${a.id}">
        <img src="${a.image}" alt="${a.name}">
        <div>
            <span>${a.category}</span>
            <strong>${a.name}</strong>
            <p>${n(a.final_price??a.price)}</p>
        </div>
        <button class="card-action" data-add-id="${a.id}">Agregar</button>
    </article>
`,h=(a=document)=>{a.querySelectorAll("[data-add-id]").forEach(e=>{e.addEventListener("click",t=>{t.stopPropagation(),sa(Number(e.dataset.addId))})})},l=(a=document)=>{a.querySelectorAll("[data-open-product]").forEach(e=>{e.addEventListener("click",()=>j(Number(e.dataset.openProduct)))})},L=(a="")=>{const e=a.trim().toLowerCase(),t=e?o.products.filter(c=>[c.name,c.category,c.description].some(s=>s.toLowerCase().includes(e))):o.products.slice(0,6);document.querySelector("#search-meta").textContent=`${t.length} resultado${t.length===1?"":"s"} encontrados`,k.innerHTML=t.map(na).join(""),l(k),h(k)};document.querySelectorAll("[data-panel-target]").forEach(a=>{a.addEventListener("click",()=>{a.dataset.panelTarget==="bag"&&p(),u(a.dataset.panelTarget)})});document.querySelectorAll("[data-close-panel]").forEach(a=>a.addEventListener("click",f));var B;(B=document.querySelector("[data-open-bag]"))==null||B.addEventListener("click",()=>{p(),u("bag")});S.addEventListener("click",f);N.addEventListener("input",a=>L(a.target.value));document.querySelectorAll("[data-search-term]").forEach(a=>{a.addEventListener("click",()=>{N.value=a.dataset.searchTerm,L(a.dataset.searchTerm)})});document.addEventListener("click",a=>{if(a.target.closest("a[data-go-home]")){a.preventDefault(),o.activeProductId=null,f(),window.scrollTo(0,0);return}const t=a.target.closest("button[data-remove-id]");if(t){a.preventDefault(),a.stopPropagation(),aa(Number(t.dataset.removeId));return}const c=a.target.closest("a[data-bridge-target]");c&&(a.preventDefault(),ea(c.dataset.bridgeTarget,c.href))});document.querySelectorAll(".size-option").forEach(a=>{a.addEventListener("click",()=>{document.querySelectorAll(".size-option").forEach(e=>e.classList.remove("active-size")),a.classList.add("active-size"),o.selectedSize=a.textContent.trim(),o.activeProductId?j(o.activeProductId):f()})});fetch(`${H}/storefront/overview`).then(async a=>{if(!a.ok)throw new Error("No se pudo cargar la tienda en este momento.");return a.json()}).then(a=>{var t;o.products=[...a.featuredProducts,...a.latestProducts].filter((c,s,i)=>i.findIndex(d=>d.id===c.id)===s);const e=a.featuredProducts[0]||a.latestProducts[0];if(e){const c=`
                linear-gradient(180deg, rgba(35, 24, 18, 0.24) 0%, rgba(18, 12, 8, 0.74) 100%),
                url('${e.image}')
            `;[X,Z,K].forEach(s=>{s.style.backgroundImage=c})}y.innerHTML=(a.featuredProducts.length?a.featuredProducts:a.latestProducts).slice(0,4).map(ra).join(""),C.innerHTML=`
            <article class="stat-card"><span>Productos</span><strong>${a.stats.products}</strong></article>
            <article class="stat-card"><span>Destacados</span><strong>${a.stats.featured}</strong></article>
            <article class="stat-card"><span>Categorias</span><strong>${a.stats.categories}</strong></article>
            <article class="stat-card"><span>Stock</span><strong>${a.stats.stock}</strong></article>
        `,g.innerHTML=a.featuredProducts.map(oa).join(""),q.innerHTML=(t=a.promotions)!=null&&t.length?a.promotions.map(ia).join(""):'<div class="product-loading">Crea promociones desde el administrador para destacarlas aqui.</div>',m.innerHTML=a.latestProducts.map(ca).join(""),l(y),l(g),l(m),h(g),h(m),L(),p()}).catch(a=>{y.innerHTML=`<div class="category-placeholder">${a.message}</div>`,C.innerHTML=`<div class="stat-card muted-card">${a.message}</div>`,g.innerHTML=`<div class="product-loading">${a.message}</div>`,q.innerHTML=`<div class="product-loading">${a.message}</div>`,m.innerHTML=`<div class="product-loading">${a.message}</div>`});
