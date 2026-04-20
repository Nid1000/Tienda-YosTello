(function(){const e=document.createElement("link").relList;if(e&&e.supports&&e.supports("modulepreload"))return;for(const r of document.querySelectorAll('link[rel="modulepreload"]'))o(r);new MutationObserver(r=>{for(const n of r)if(n.type==="childList")for(const b of n.addedNodes)b.tagName==="LINK"&&b.rel==="modulepreload"&&o(b)}).observe(document,{childList:!0,subtree:!0});function s(r){const n={};return r.integrity&&(n.integrity=r.integrity),r.referrerPolicy&&(n.referrerPolicy=r.referrerPolicy),r.crossOrigin==="use-credentials"?n.credentials="include":r.crossOrigin==="anonymous"?n.credentials="omit":n.credentials="same-origin",n}function o(r){if(r.ep)return;r.ep=!0;const n=s(r);fetch(r.href,n)}})();const C="http://127.0.0.1:8000/api".replace(/\/$/,""),t=C.replace(/\/api$/,""),E=document.querySelector("#app");E.innerHTML=`
    <div class="page-shell">
        <div class="topbar">
            <button class="topbar-contact" data-panel-target="contact">+ Pongase en contacto con nosotros</button>
            <a class="topbar-brand" href="#" data-go-home>YO-TELLO</a>
            <div class="topbar-right">
                <button class="topbar-action" data-panel-target="bag">Bolsa <span id="bag-count" class="action-count">0</span></button>
                <button class="topbar-action" data-panel-target="account">Cuenta</button>
                <button class="topbar-action" data-panel-target="search">Buscar</button>
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
                    <a class="dialog-button primary-dialog" href="${t}/checkout" target="_blank" rel="noreferrer" data-bridge-target="checkout">Finalizar la compra</a>
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
            <div id="account-visual" class="account-visual">
                <div class="account-visual-copy">
                    <span>Cuenta YO-TELLO</span>
                    <strong>Accede a tus pedidos, direcciones y seleccion guardada</strong>
                </div>
            </div>
            <div class="account-card-wrap">
                <div class="account-card">
                    <a href="${t}/login" target="_blank" rel="noreferrer" data-bridge-target="cart">Iniciar sesion</a>
                    <a href="${t}/pedidos" target="_blank" rel="noreferrer">Mis pedidos</a>
                    <a href="${t}/dashboard" target="_blank" rel="noreferrer">Ajustes de la cuenta</a>
                    <a href="${t}/dashboard" target="_blank" rel="noreferrer">Mi libreta de direcciones</a>
                    <a href="${t}/checkout" target="_blank" rel="noreferrer">Tarjeta de credito</a>
                    <a href="${t}/productos" target="_blank" rel="noreferrer">Guardados</a>
                    <a href="mailto:hola@yotello.com" target="_blank" rel="noreferrer">Mis citas</a>
                </div>
            </div>
        </section>

        <section id="menu-panel" class="menu-panel hidden">
            <div id="menu-visual" class="menu-visual">
                <div class="menu-visual-copy">
                    <span>YO-TELLO</span>
                    <strong>Explora la tienda con una navegacion editorial conectada al backend</strong>
                </div>
            </div>
            <div class="menu-content">
                <button class="menu-close" data-close-panel aria-label="Cerrar menu">x</button>
                <div class="menu-columns">
                    <nav class="menu-primary">
                        <a href="${t}/productos" target="_blank" rel="noreferrer">Novedades</a>
                        <a href="${t}/productos?categoria=ropa" target="_blank" rel="noreferrer">Ropa</a>
                        <a href="${t}/productos?categoria=zapatillas" target="_blank" rel="noreferrer">Zapatillas</a>
                        <a href="${t}/productos?categoria=accesorios" target="_blank" rel="noreferrer">Accesorios</a>
                        <a href="${t}/productos?categoria=bolsos" target="_blank" rel="noreferrer">Bolsos</a>
                    </nav>
                    <div class="menu-secondary">
                        <a href="${t}/productos" target="_blank" rel="noreferrer">Catalogo completo</a>
                        <a href="${t}/admin" target="_blank" rel="noreferrer">Administrador</a>
                        <a href="${t}/login" target="_blank" rel="noreferrer" data-bridge-target="cart">Iniciar sesion</a>
                        <a href="${t}/pedidos" target="_blank" rel="noreferrer">Mis pedidos</a>
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
                            <a href="${t}/productos" target="_blank" rel="noreferrer">Catalogo completo</a>
                            <a href="${t}/admin" target="_blank" rel="noreferrer">Panel admin</a>
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
                            <a class="campaign-button bag-primary-link" href="${t}/productos" target="_blank" rel="noreferrer">Seguir comprando</a>
                            <a class="bag-secondary-link" href="${t}/checkout" target="_blank" rel="noreferrer">Ir a checkout</a>
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
                    <p class="campaign-kicker">Nuevos estilos de temporada</p>
                    <h1>Moda premium conectada a tu backend real.</h1>
                    <a href="#featured-products" class="campaign-button">Comprar</a>
                </div>
            </section>

            <section class="editorial-section backend-strip">
                <div class="section-copy">
                    <p class="section-kicker">Backend</p>
                    <h2>Productos, categorias y stock reales</h2>
                    <p>La portada toma datos desde Laravel API para que frontend y backend se sientan como una sola tienda.</p>
                </div>
                <div id="backend-stats" class="backend-stats">
                    <div class="stat-card muted-card">Conectando con el backend...</div>
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
                        <a href="${t}/productos" target="_blank" rel="noreferrer">Descubrir</a>
                    </article>
                    <article class="service-card">
                        <div class="service-image service-image-stone"></div>
                        <strong>Recogida en tienda</strong>
                        <p>Compra online y recoge tu pedido en el punto que prefieras.</p>
                        <a href="${t}/checkout" target="_blank" rel="noreferrer">Como funciona</a>
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
                        <a href="${t}/pedidos" target="_blank" rel="noreferrer">Mi pedido</a>
                        <a href="${t}/productos" target="_blank" rel="noreferrer">Mapa del sitio</a>
                    </div>
                    <div>
                        <h3>Empresa</h3>
                        <a href="${t}/admin" target="_blank" rel="noreferrer">Panel administrador</a>
                        <a href="${t}/productos" target="_blank" rel="noreferrer">Colecciones</a>
                        <a href="${t}/login" target="_blank" rel="noreferrer" data-bridge-target="cart">Iniciar sesion</a>
                    </div>
                    <div>
                        <h3>Servicios</h3>
                        <a href="mailto:hola@yotello.com">Reservar cita</a>
                        <a href="${t}/checkout" target="_blank" rel="noreferrer">Checkout</a>
                        <a href="${t}/carrito" target="_blank" rel="noreferrer">Bolsa</a>
                    </div>
                </div>
                <div class="footer-mark">
                    <span class="footer-mark-symbol">YT</span>
                    <strong>YO-TELLO</strong>
                </div>
            </footer>
        </main>
    </div>
`;const $=document.querySelector("#overlay"),z=document.querySelector("#contact-visual"),P=document.querySelector("#menu-visual"),M=document.querySelector("#account-visual"),h=document.querySelector("#category-grid"),L=document.querySelector("#backend-stats"),u=document.querySelector("#featured-grid"),p=document.querySelector("#latest-grid"),O=document.querySelector("#bag-count"),f=document.querySelector("#bag-content"),S=document.querySelector("#bag-heading"),q=document.querySelector("#search-input"),y=document.querySelector("#search-results"),g=document.querySelector("#product-detail"),A=document.querySelector("#cart-dialog-body"),c={products:[],cart:JSON.parse(localStorage.getItem("yotello-cart")||"[]"),selectedSize:"M / 40",activeProductId:null},i=a=>new Intl.NumberFormat("es-CO",{style:"currency",currency:"COP",maximumFractionDigits:0}).format(a||0),w=()=>localStorage.setItem("yotello-cart",JSON.stringify(c.cart)),U=(a,e)=>{if(!c.cart.length){window.open(e,"_blank","noopener,noreferrer");return}const s=document.createElement("form");s.method="POST",s.action=`${t}/bridge/cart`,s.target="_blank",s.style.display="none";const o=document.createElement("input");o.type="hidden",o.name="target",o.value=a;const r=document.createElement("input");r.type="hidden",r.name="cart",r.value=JSON.stringify(c.cart.map(n=>({id:n.id,qty:n.qty,size:n.size||c.selectedSize}))),s.appendChild(o),s.appendChild(r),document.body.appendChild(s),s.submit(),s.remove()},d=a=>{var e;document.querySelectorAll(".contact-panel, .account-panel, .menu-panel, .search-panel, .product-panel, .bag-view, .size-panel, .cart-dialog").forEach(s=>s.classList.add("hidden")),$.classList.remove("hidden"),(e=document.querySelector(`#${a}-panel, #${a}`))==null||e.classList.remove("hidden")},T=()=>{document.querySelectorAll(".contact-panel, .account-panel, .menu-panel, .search-panel, .product-panel, .bag-view, .size-panel, .cart-dialog").forEach(a=>a.classList.add("hidden")),$.classList.add("hidden")},x=a=>{var o;const e=c.products.find(r=>r.id===a);if(!e)return;c.activeProductId=a;const s=c.products.filter(r=>r.category===e.category).slice(0,4);g.innerHTML=`
        <div class="product-hero">
            <div class="product-hero-image">
                <img src="${e.image}" alt="${e.name}">
            </div>
            <div class="product-thumb-row">
                ${(s.length?s:[e]).map(r=>`
                    <button class="product-thumb ${r.id===e.id?"active-thumb":""}" data-open-product="${r.id}">
                        <img src="${r.image}" alt="${r.name}">
                    </button>
                `).join("")}
            </div>
        </div>
        <div class="product-content">
            <div class="product-copy-area">
                <span class="product-category">${e.category}</span>
                <h2>${e.name}</h2>
                <strong class="product-price">${i(e.final_price??e.price)}</strong>
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
                <a class="product-window-link" href="${t}/productos" target="_blank" rel="noreferrer">Ver catalogo completo</a>
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
    `,l(g),v(g),(o=g.querySelector("[data-open-size]"))==null||o.addEventListener("click",()=>d("size")),d("product")},B=a=>{A.innerHTML=`
        <img src="${a.image}" alt="${a.name}">
        <div>
            <strong>${a.name}</strong>
            <p>${i(a.final_price??a.price)}</p>
            <span>Categoria: ${a.category}</span>
        </div>
    `,d("cart-dialog")},H=a=>{const e=c.products.find(o=>o.id===a);if(!e)return;const s=c.cart.find(o=>o.id===a);s?(s.qty+=1,s.size=s.size||c.selectedSize):c.cart.push({id:e.id,name:e.name,category:e.category,image:e.image,final_price:e.final_price??e.price,qty:1,size:c.selectedSize}),w(),m(),B(e)},m=()=>{const a=c.cart.reduce((e,s)=>e+s.qty,0);if(O.textContent=String(a),c.cart.length===0)S.textContent="Su bolsa de compra esta actualmente vacia",f.innerHTML=`
            <div class="bag-empty-layout">
                <div class="bag-empty-visual"></div>
                <div class="bag-recommendations">
                    <h3>Quizas tambien le guste</h3>
                    <div class="bag-product-strip">
                        ${c.products.slice(0,4).map(e=>`
                            <article class="bag-suggestion" data-open-product="${e.id}">
                                <img src="${e.image}" alt="${e.name}">
                                <strong>${e.name}</strong>
                                <span>${i(e.final_price??e.price)}</span>
                            </article>
                        `).join("")}
                    </div>
                </div>
            </div>
        `;else{const e=c.cart.reduce((s,o)=>s+o.final_price*o.qty,0);S.textContent=`Tiene ${a} articulo${a===1?"":"s"} en su bolsa`,f.innerHTML=`
            <div class="bag-filled-layout">
                <div class="bag-item-list">
                    ${c.cart.map(s=>`
                        <article class="bag-line">
                            <img src="${s.image}" alt="${s.name}">
                            <div>
                                <strong>${s.name}</strong>
                                <p>${s.category}</p>
                                <p>Talla: ${s.size||c.selectedSize}</p>
                                <span>Cantidad: ${s.qty}</span>
                                <button class="bag-remove" type="button" data-remove-id="${s.id}">Eliminar</button>
                            </div>
                            <strong>${i(s.final_price*s.qty)}</strong>
                        </article>
                    `).join("")}
                </div>
                <aside class="bag-summary-card">
                    <div class="bag-summary-row"><span>Subtotal</span><strong>${i(e)}</strong></div>
                    <div class="bag-summary-row"><span>Envio</span><strong>Gratis</strong></div>
                    <div class="bag-summary-row total-row"><span>Total estimado</span><strong>${i(e)}</strong></div>
                    <div class="bag-summary-actions">
                        <a class="dialog-button primary-dialog" href="${t}/checkout" target="_blank" rel="noreferrer" data-bridge-target="checkout">Continuar compra</a>
                        <a class="dialog-button secondary-dialog" href="${t}/carrito" target="_blank" rel="noreferrer" data-bridge-target="cart">Abrir carrito Laravel</a>
                    </div>
                </aside>
            </div>
        `}l(f)},N=(a,e)=>`
    <article class="category-card tone-${e%4+1}" data-open-product="${a.id}">
        <div class="category-image-wrap">
            <img src="${a.image}" alt="${a.name}">
        </div>
        <div class="category-caption">
            <strong>${a.category}</strong>
            <span>${a.name}</span>
        </div>
    </article>
`,I=a=>`
    <article class="feature-card" data-open-product="${a.id}">
        <img src="${a.image}" alt="${a.name}">
        <div class="feature-card-copy">
            <span>${a.category}</span>
            <h3>${a.name}</h3>
            <p>${a.description}</p>
            <strong>${i(a.final_price??a.price)}</strong>
            <button class="card-action" data-add-id="${a.id}">Agregar a bolsa</button>
        </div>
    </article>
`,j=a=>`
    <article class="latest-card" data-open-product="${a.id}">
        <img src="${a.image}" alt="${a.name}">
        <div class="latest-card-copy">
            <span>${a.category}</span>
            <h3>${a.name}</h3>
            <strong>${i(a.final_price??a.price)}</strong>
            <button class="card-action" data-add-id="${a.id}">Agregar</button>
        </div>
    </article>
`,D=a=>`
    <article class="search-card" data-open-product="${a.id}">
        <img src="${a.image}" alt="${a.name}">
        <div>
            <span>${a.category}</span>
            <strong>${a.name}</strong>
            <p>${i(a.final_price??a.price)}</p>
        </div>
        <button class="card-action" data-add-id="${a.id}">Agregar</button>
    </article>
`,v=(a=document)=>{a.querySelectorAll("[data-add-id]").forEach(e=>{e.addEventListener("click",s=>{s.stopPropagation(),H(Number(e.dataset.addId))})})},l=(a=document)=>{a.querySelectorAll("[data-open-product]").forEach(e=>{e.addEventListener("click",()=>x(Number(e.dataset.openProduct)))})},k=(a="")=>{const e=a.trim().toLowerCase(),s=e?c.products.filter(o=>[o.name,o.category,o.description].some(r=>r.toLowerCase().includes(e))):c.products.slice(0,6);document.querySelector("#search-meta").textContent=`${s.length} resultado${s.length===1?"":"s"} encontrados`,y.innerHTML=s.map(D).join(""),l(y),v(y)};document.querySelectorAll("[data-panel-target]").forEach(a=>{a.addEventListener("click",()=>{a.dataset.panelTarget==="bag"&&m(),d(a.dataset.panelTarget)})});document.querySelectorAll("[data-close-panel]").forEach(a=>a.addEventListener("click",T));var _;(_=document.querySelector("[data-open-bag]"))==null||_.addEventListener("click",()=>{m(),d("bag")});$.addEventListener("click",T);q.addEventListener("input",a=>k(a.target.value));document.querySelectorAll("[data-search-term]").forEach(a=>{a.addEventListener("click",()=>{q.value=a.dataset.searchTerm,k(a.dataset.searchTerm)})});document.addEventListener("click",a=>{const e=a.target.closest("a[data-bridge-target]");if(!e)return;a.preventDefault(),U(e.dataset.bridgeTarget,e.href)});document.querySelectorAll(".size-option").forEach(a=>{a.addEventListener("click",()=>{document.querySelectorAll(".size-option").forEach(e=>e.classList.remove("active-size")),a.classList.add("active-size"),c.selectedSize=a.textContent.trim(),c.activeProductId?x(c.activeProductId):T()})});fetch(`${C}/storefront/overview`).then(async a=>{if(!a.ok)throw new Error("No se pudo cargar la portada desde el backend.");return a.json()}).then(a=>{c.products=[...a.featuredProducts,...a.latestProducts].filter((s,o,r)=>r.findIndex(n=>n.id===s.id)===o);const e=a.featuredProducts[0]||a.latestProducts[0];if(e){const s=`
                linear-gradient(180deg, rgba(35, 24, 18, 0.24) 0%, rgba(18, 12, 8, 0.74) 100%),
                url('${e.image}')
            `;[z,P,M].forEach(o=>{o.style.backgroundImage=s})}h.innerHTML=(a.featuredProducts.length?a.featuredProducts:a.latestProducts).slice(0,4).map(N).join(""),L.innerHTML=`
            <article class="stat-card"><span>Productos</span><strong>${a.stats.products}</strong></article>
            <article class="stat-card"><span>Destacados</span><strong>${a.stats.featured}</strong></article>
            <article class="stat-card"><span>Categorias</span><strong>${a.stats.categories}</strong></article>
            <article class="stat-card"><span>Stock</span><strong>${a.stats.stock}</strong></article>
        `,u.innerHTML=a.featuredProducts.map(I).join(""),p.innerHTML=a.latestProducts.map(j).join(""),l(h),l(u),l(p),v(u),v(p),k(),m()}).catch(a=>{h.innerHTML=`<div class="category-placeholder">${a.message}</div>`,L.innerHTML=`<div class="stat-card muted-card">${a.message}</div>`,u.innerHTML=`<div class="product-loading">${a.message}</div>`,p.innerHTML=`<div class="product-loading">${a.message}</div>`});
document.addEventListener("click",a=>{const e=a.target.closest("button[data-remove-id]");if(!e)return;a.preventDefault(),a.stopPropagation(),c.cart=c.cart.filter(s=>s.id!==Number(e.dataset.removeId)),w(),m()});
document.addEventListener("click",a=>{const e=a.target.closest("a[data-go-home]");if(!e)return;a.preventDefault(),c.activeProductId=null,T(),window.scrollTo(0,0)});
