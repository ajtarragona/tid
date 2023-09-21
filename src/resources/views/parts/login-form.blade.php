<div class="login-container">
    <div class="login-form">
            <section class="login-title">
                <h4 >Vàlid</h4>
                <div class="aoc-logo"><img src="{{asset('vendor/ajtarragona/img/tid/logo-aoc.svg')}}"/></div>
            </section>
            <p>
                <strong>Identificació mitjançant la plataforma Vàlid del Consorci Administració Oberta de Catalunya</strong>
            </p>
            <p>
                Permet la identificació mitjançant qualsevol dels mètodes compatibles amb la plataforma (alguns mètodes requereixen un registre previ)
            </p>

            @if(request()->error)
                <div class="login-error">{{ request()->error }}</div>
            @endif
            <ul class="validation-types">
                
                <li >
                    <img src="{{asset('vendor/ajtarragona/img/tid/icon-dni.svg')}}"/>
                    <span class="label">DNI electrònic</span>
                </li>
                <li >
                    <img src="{{asset('vendor/ajtarragona/img/tid/icon-cert.svg')}}"/>

                    <span class="label">Certificat digital</span>
                </li>
                <li >
                    <img src="{{asset('vendor/ajtarragona/img/tid/icon-idcat.svg')}}"/>
                    <span class="label">idCAT Mòbil</span>
                </li>
            </ul>

            <section class="validate-btn-container">
                
                <a class="validate-btn" tabindex="0" aria-disabled="false" href="{{tid()->makeValidUrl()}}">
                    <span class="">
                        <span >Vàlid</span>
                        <span ><img src="{{asset('vendor/ajtarragona/img/tid/icon-arrow.svg')}}"/></span>
                    </span>
                </a>
            </section>
        
    </div>
</div>