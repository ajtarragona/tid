<div class="login-container ">
    <h1 >Verifiqueu la vostra identitat</h1>


    <div class="login-form">
        
            
            
            @if(config('tid.test_mode'))
            <div class="test-mode-warning">
                <strong>TEST MODE</strong>

                <p>Introdueix manualment les teves dades.</p>
            </div>
            <form method="post" action="{{ route('tid.setsession')}}">
                @csrf
                <input type="text" placeholder="NIF" name="identifier" class="form-control " required/>
                <input type="text" placeholder="Name" name="name" class="form-control " required/>
                <input type="text" placeholder="Cognoms" name="surnames" class="form-control " required/>
                {{-- <input type="text" placeholder="Cognom1" name="surname1" class="form-control " />
                <input type="text" placeholder="Cognom2" name="surname2" class="form-control "/> --}}
                <input type="email" placeholder="Email" name="email" class="form-control "/>
                <input type="text" placeholder="Phone" name="phone" class="form-control "/>
                <hr/>
                <input type="text" placeholder="CIF" name="companyId" class="form-control " />
                <input type="text" placeholder="Raó Social" name="companyName" class="form-control " />
                
                <section class="validate-btn-container ">
                        <button type="submit" class="validate-btn" tabindex="0" aria-disabled="false">
                            <span class="">
                                <span >Accedir</span>
                                <span ><img src="{{asset('vendor/ajtarragona/img/tid/icon-arrow.svg')}}"/></span>
                            </span>
                        </button>
                    </section>
                    
            </form>
            @else
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
                    
                
                    @if(config('tid.test_mode'))
                        <a class="validate-btn" tabindex="0" aria-disabled="false" href="#">
                            <span class="">
                                <span >Test Mode</span>
                                <span ><img src="{{asset('vendor/ajtarragona/img/tid/icon-arrow.svg')}}"/></span>
                            </span>
                        </a>
                    @else
                        <a class="validate-btn" tabindex="0" aria-disabled="false" href="{{tid()->makeValidUrl()}}">
                            <span class="">
                                <span >Vàlid</span>
                                <span ><img src="{{asset('vendor/ajtarragona/img/tid/icon-arrow.svg')}}"/></span>
                            </span>
                        </a>
                    @endif
                </section>

            @endif

            
            
        
    </div>
</div>