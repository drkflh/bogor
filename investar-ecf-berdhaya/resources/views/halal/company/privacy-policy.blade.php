<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Premium Bootstrap 5 Landing Page Template" />
        <meta name="keywords" content="bootstrap 5, premium, marketing, multipurpose" />
        <meta name="author" content="Coderthemes" />

        <!-- Site Title -->
        <title>{{ env('SITE_TITLE') }}</title>
        <!-- Site favicon -->
        <!-- Light-box -->
        <link rel="stylesheet" href="{{ url('themes/dojek') }}/css/mklb.css" type="text/css" />

        <!-- Swiper js -->
        <link rel="stylesheet" href="{{ url('themes/dojek') }}/css/swiper-bundle.min.css" type="text/css" />

        <!--Material Icon -->
        <link rel="stylesheet" type="text/css" href="{{ url('themes/dojek') }}/css/materialdesignicons.min.css" />

        <link rel="stylesheet" href="{{ url('themes/dojek') }}/css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ url('themes/dojek') }}/css/style.css" />
        <link rel="stylesheet" type="text/css" href="{{ url('css/theme/dojek.css') }}" />
        <!-- icon line -->
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}"/>
        <script src="{{ url( 'js/jquery-3.6.0.min.js' ) }}"></script>

        @yield('js')
    </head>

    <body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="60">
        <!--Navbar Start-->
        <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky-dark" id="navbar-sticky">
            <div class="container">
                <!-- LOGO -->
                <a class="logo text-uppercase" href="{{ url('/') }}">
                    <img src="{{ url( env('APP_LOGO') ) }}" alt="" height="50">
                    @if(env('LOGO_TEXT', false ))
                        <span class="sidebar-brand" style="font-size: 15pt;font-weight: bold;">{{ env('SITE_TITLE') }}</span>
                    @endif
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="mdi mdi-menu"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ms-auto navbar-center" id="mySidenav">
                        @include(env('APP_OPEN_NAV_VIEW'))
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- home-agency start -->
        <section class="hero-5" id="home">
            <div class="container">
                <div>
                    <h5 class="border-bottom fs-22 pb-3 mb-4"><strong>{{ $title }}</strong></h5>                   
                </div>
                <p>
                        The following Privacy Policy describes how we, temanQu (PT Nilam Anugerah Internasional, and affiliates, “<strong>we</strong>”, “<strong>us</strong>” or “<strong>our</strong>”) collect, store, use, process, retain, transfer, disclose and protect your Personal Information. This Privacy Policy applies to all users of our applications, websites (www.temanqu.id), services, or products (“<strong>Applications</strong>”), unless covered by a separate privacy policy.
                    Please read this Privacy Policy thoroughly to ensure that you understand our data processing practices. Unless otherwise defined, all capitalized terms used in this Privacy Policy shall have the same meaning ascribed to them in the Terms of Use.
                    This Privacy Policy includes the following matters:
                <ol>
                    <li>Personal Information which we collect</li>
                    <li>The use of Personal Information which we collect</li>
                    <li>Sharing of Personal Information which we collect</li>
                    <li>Retention of Personal Information</li>
                    <li>Access and correction of Personal Information</li>
                    <li>Where we store your Personal Information</li>
                    <li>Security of your Personal Information</li>
                    <li>Changes to this Privacy Policy</li>
                    <li>Acknowledgment and consent</li>
                    <li>Marketing and promotional material</li>
                    <li>Anonymous Data</li>
                    <li>Third party platforms</li>
                    <li>How to contact us</li>
                </ol>
                </p>
                
                <div class="accordion" id="accordionExample">
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingOne">
						    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
							    <strong>Personal Information which we collect</strong>
						    </button>
						</h2>
					<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
					    <div class="accordion-body">	
                            We collect information which identifies or can be used to identify, contact, or locate the person or device to whom that information pertains (“<strong>Personal Information</strong>”). Personal Information includes, but not limited to, name, address, date of birth, occupation, phone number, e-mail address, bank account and credit-card details, gender, identification (including KTP, SIM, or Passport) or other government issued identifier, vehicle information, photo, nationality, phone number of our users and non-users in your mobile phonebook, health data, financial related information, and biometric information (including but not limited to facial recognition). Additionally, to the extent other information, including a personal profile, and/or unique identifier, is associated or combined with Personal Information, then that information is also Personal Information. The Personal Information which we collect may be provided by you directly or by third parties (for example: when you register or use the Application, when you contact our customer services, or you otherwise provide Personal Information to us). We may collect information in various forms and purposes (including purposes permitted under applicable law).
                            <br><br>
                            <strong>Information obtained from you or from your mobile device directly</strong>
                            <ul>
                            <li>When you register and create an account with us using the Application you have to provide to us certain Personal Information, including your name, physical address, e-mail address and your phone number. If you are using the Application as a service provider, you have to provide us with additional Personal Information as part of the service provider onboarding process. This would include details of your vehicle (licenses, approvals, and other authorizations for you to operate the vehicle and to provide the transportation services), your insurance policy, and your bank account.</li>
                            <li>When you use the Application, you have to provide us with relevant information as may reasonably be required by us in order for the Application to work, for example:</li>
                            <ul>
                            <li>If you are using the Application as a user, you will need to provide us with information as to the type of service you seek, and details as to the pick-up and/or delivery.</li>
                            <li>If you are using the Application as a service provider, in order for the Application to work, you will need to provide us with the information on the services you are able to accept orders for at the time, and details as to your current, and after an order for a service placed by a user is accepted by you as the service provider, you may need to provide us with other data that we need to manage the Application and ecosystem, and to monitor overall usage of the Application.</li>
                            <li>If you utilize and/or when a payment or transfer is made through the electronic money and/or electronic wallet facility provided by us, if you are the payer or sender, you will provide us the information relating to the utilization, payment or transfer, including but not limited to the transfer and/or payment receiver details, the amount of payment paid, the type of payment card or account used, the name of the issuer of that payment card or account, the name of the holder for that payment card or account, the identification number of that payment card or account, the verification code of that payment card or account and the expiration date of that payment card or account, as applicable.</li>
                            <li>If you intend to apply as registered or verified account holder of the electronic money facility provided by us, you will provide to us the required information including but not limited to your full name, your identity card numbers, type of identity card you use for registration, address, gender, place and date of birth, occupation, tax details, nationality and/or biometric data.</li>
                            <li>If you intend to add your payment card or account as a source of fund for payment in the Application, you will provide us information relating to the type of payment card or account registered, the issuer of that payment card or account, the name of the holder for that payment card or account, the identification number of that payment card or account and the verification code of that payment card or account and the expiration date of that payment card or account, as applicable.</li>
                            </ul>                                  
                            </ul>
                            <strong>Information collected whenever you use the Application or visit our website</strong>
                            <ul>
                            <li>Whenever you use the Application or visit our website, we may collect certain technical data concerning your usage such as, internet protocol (IP) address, information as web pages previously or subsequently viewed, duration of every visit/session, the internet device identity (ID) or media access control address, mobile advertising ID and other device information including information regarding the manufacturer, model and operating system of the device that you use to access the Application or our website.</li>
                            <li>Whenever you use the Application or visit our website, certain information may also be collected on an automated basis using cookies. Cookies are small application files stored on your computer or mobile device. We use cookies to track user activity to enhance user interface and experience. Most mobile devices and internet browsers support the use of cookies; but you may adjust the settings on your mobile device or internet browser to reject several types of certain cookies or certain specific cookies. Your mobile device and/or browser would also enable you to delete at any time whatever cookies have previously been stored. However, doing so may affect the functionalities available on the Application or our website.</li>
                            <li>Whenever you use the Application through your mobile device, we will track and collect your geo-location information in real-time. In some cases, you will be prompted or required to activate the Global Positioning System (GPS) on your mobile device to enable us to give you a better experience in using the Application (for example, to give you information as to how close a service provider is to you). You can always choose to disable the geo-location tracking information on your mobile device temporarily. However, this can affect the functionalities available on the Application.</li>
                            <li>If you utilize and/or when a payment or transfer is made through the electronic money and/or electronic wallet facility provided by us, we may collect certain information related to your source of fund for top up (including bank account details), account details of withdrawal receiver, transaction history (including receiver details), bill details, invoice details and phone number details.</li>
                            <li>If you utilize virtual account provided by us to receive electronic money and/or electronic wallet payment from payer, whether you are a service provider or merchant, we may collect certain information related to your utilization including but not limited to service and/or goods transacted, amount you collect from every transaction, withdrawal or settlement account details and withdrawal or settlement history.</li>
                            <li>If you utilize and/or when a payment is made through the payment card or account you add in the Application, we may collect certain information related to the transaction history (including receiver details), bill details, invoice details, and phone number details.</li>                                   
                            </ul>
                            <strong>Information collected from third parties</strong>
                            <div>We may also collect your Personal Information from third parties (including our agents, vendors, suppliers, contractors, partners and any others who provide services to us, who collect your Personal Information and/or perform functions on our behalf, or whom we collaborate with). In such cases, we will only collect your Personal Information for or in connection with the purposes for which such third parties are engaged or the purposes of our collaboration with such third parties (as the case may be). Specifically, when you register for a payment card or account through the Application and/or access, add and/or link a payment card or account to the Application, we may collect certain financial information and financial history of yours (including but not limited to payment card or account transaction history, payment card or account details and mapping and/or payment card or account status and states) from the issuer of such payment credential or any other third parties.</div>
                            <br>
                            <strong>Information about third parties you provided to us</strong>
                            <ul>
                            <li>You may provide us with Personal Information relating to other third-party individuals (including Personal Information relating to your spouse, family members, friends, or other individuals). you will, of course, need their consent to do so – see “Acknowledgement and Consent”, below, for further information.</li>
                            <li>We do not mandate or endorse, nor prohibit, the installation or use of in-vehicle recording devices in any Vehicles. Where such devices are installed and used in any Vehicles, we do not collect any Personal Information from any in-vehicle recordings by such devices, and any collection of Personal Information from such in-vehicle recordings is not being done on our behalf. The collection of Personal Information from such in-vehicle recordings is solely at the discretion of the service provider. We have no control over such collection of Personal Information by the service provider and any subsequent use or disclosure by the service provider of the Personal Information so collected. Where you are a service provider and choose to install and use such in-vehicle recording devices in your Vehicle, it is your sole responsibility to notify the user of the same. Where you are a user and you have any objection to the use of in-vehicle recording devices within the Vehicle of any service provider, you must inform the service provider directly and it will be your personal responsibility to do so.</li>
                            <li>When you are using the chat features in our Application, you will provide us with the phone numbers of our Application users stored on your mobile phonebook to enable you in using our chat features and for other internal purposes.</li>
                            </ul>
                        </div>
					</div>
					</div>
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingTwo">
						    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <strong>The use of Personal Information which we collect</strong>
						    </button>
						</h2>
						<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
							<div class="accordion-body">	
                                We may use Personal Information collected for any of the following purposes as well as for such other purposes as are permitted by applicable law (“<strong>Purposes</strong>”):
                                <ol Type="a">
                                    <li>
                                    Where you are a user, we may use your Personal Information:
                                        <ul>
                                        <li>to identify you and to register you as a user and to administer, verify, deactivate, or manage your account as such;</li>
                                        <li>to facilitate or enable any verification as we may in our discretion consider necessary before the service provider provide you with the services or before we register you as a user, including performing Know Your Customer (KYC) and credit scoring;</li>
                                        <li>to enable service providers to provide you with such of the services as you have requested;</li>
                                        <li>to process and facilitate orders and payment transactions made by you, including where applicable, transactions made through any payment card or account available over the Application;</li>
                                        <li>to notify you of any transaction or activities occurred within the Application or other system linked to our Application;</li>
                                        <li>to communicate with you and to send you information in connection with the use of the Application;</li>
                                        <li>to notify you of any updates to the Application or changes to the services available;</li>
                                        <li>to process and respond to enquiries and feedback received from you;</li>
                                        <li>to maintain, develop, test, enhance and personalize the Application to meet your needs and preferences as a user;</li>
                                        <li>to monitor and analyze user activities, behavior, and demographic data including trends and usage of the various services available on the Application;</li>
                                        <li>to process and manage your reward points,</li>
                                        <li>to offer or provide services from our affiliates or partners; and</li>
                                        <li>to send you direct or targeted marketing communications, advertisements, vouchers, surveys, and information on special offers or promotions.</li>
                                        </ul>
                                    </li>
                                    <li>
                                    Where you are a service provider, we may use your Personal Information:
                                        <ul>
                                            <li>to identify you and to register you as a service provider and to administer, manage or verify your Account as such;</li>
                                            <li>to facilitate or enable any verification as we may in our discretion consider necessary before we register you as a service provider, including for KYC and credit scoring;</li>
                                            <li>to enable you to provide services to users;</li>
                                            <li>to process, facilitate, and complete payments due to you relating to any services you have provided;</li>
                                            <li>to communicate with you and send you information in relation to the provision of your services, including to relay user orders to you and to facilitate your acceptance of such orders;</li>
                                            <li>to provide you with notification and updates on the Application or changes to the manner in which services are to be provided;</li>
                                            <li>to provide you with a report in relation to the Services that you have provided;</li>
                                            <li>to process and respond to feedback from users on the services which you have provided;</li>
                                            <li>to maintain, develop, test, enhance and personalize the Application to meet your needs and preferences as a service provider;</li>
                                            <li>to monitor and analyze user activities, behavior, and demographic data including trends and service provider responsiveness for the various services available on the Application;</li>
                                            <li>to process and manage your reward points;</li>
                                            <li>to offer or provide services from our affiliates or partners;</li>
                                            <li>to send you direct or targeted marketing communications, advertisement, promos, surveys, and information on special offers or promotions.</li>
                                        </ul>
                                    </li>
                                    <li>
                                    Whether you are a user or a service provider or otherwise provide Personal Information to us, we may also use your Personal Information more generally for the following purposes (although we will in each such case always act reasonably and use no more Personal Information than what is required for the particular purpose):
                                        <ul>
                                            <li>to undertake associated business processes and functions;</li>
                                            <li>to monitor usage of the Application and administer, support and improve the performance efficiency, growth, user experience and the functions of the Application;</li>
                                            <li>to provide assistance in relation to and to resolve any technical difficulties or operational problems with the Application or the services;</li>
                                            <li>to generate statistical information and analytics data for the purpose of testing, research, analysis, product development, commercial partnership, and collaboration;</li>
                                            <li>to prevent, detect and investigate any prohibited, illegal, unauthorized or fraudulent activities;</li>
                                            <li>to facilitate business asset transactions (which may extend to any mergers, acquisitions or asset sales) involving us and/or any of our affiliates; and</li>
                                            <li>to enable us to comply with our obligations under any applicable law, including but not limited to responding to regulatory enquiries, investigations or directives, complying with regulatory filing, reporting, and licensing requirements, and conducting audit checks, due diligence and investigations.</li>
                                        </ul>
                                    </li>
                                </ol>
                            </div>
						</div>
					</div>
                    <div class="accordion-item">
						<h2 class="accordion-header" id="headingThree">
						    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						        <strong>Sharing of Personal Information which we collect</strong>
						    </button>
						</h2>
						<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
						    <div class="accordion-body">	
                                <ul>
                                    <li>
                                    We may disclose to, allow access to or share with affiliates and other parties your Personal Information for any of the following purposes as well as for such other purposes as are permitted by applicable law:
                                        <ul>
                                            <li>where you are a user, for the purpose of enabling a service provider, to perform or deliver a service;</li>
                                            <li>where you are a service provider, for the purpose of enabling a user to request or receive a service from you;</li>
                                            <li>where required or authorized by applicable law (including but not limited to responding to regulatory enquiries, investigations or directives, or complying with statutory or regulatory filing and reporting, and licensing requirements), for the purpose so specified in that applicable law;</li>
                                            <li>where instructed, requested, required or authorized by the government authorities, for the purpose as specified in the government policy, regulations or applicable law</li>
                                            <li>where there is any form of legal proceeding between you and us, or between you and another party, in connection with, or relating to the services, for the purposes of that legal proceeding;</li>
                                            <li>in relation to any verification as we or other third party may consider necessary before the service provider provide you with the services or we register you as a user, including for KYC and credit scoring;</li>
                                            <li>where we enable our services in third parties’ platform, (i) to assist us in obtaining your Personal Information and/or (ii) to register you or allow you to use our services from such platforms.</li>
                                            <li>in an emergency concerning your safety (whether you are a user or a service provider) for the purposes of dealing with that emergency;</li>
                                            <li>in a situation concerning your health or public interest (whether you are a user or a service provider), we may share your Personal Information to the government authorities and/or other institutions that may be appointed by the government authorities or have a cooperation with us, for the purposes of contact tracing, supporting government initiatives, policies or programs, public safety and any other purposes reasonably needed;</li>
                                            <li>in connection with, any merger, sale of company assets, consolidation or restructuring, financing or acquisition of all or a portion of our business by or into another company, for the purposes of such a transaction (even if the transaction is eventually not proceeded with);</li>
                                            <li>in connection with insurance claim, we will share your Personal Information for the purpose of processing the insurance claim to the insurance company that we engage or have collaboration with;</li>
                                            <li>to third parties (including our agents, vendors, suppliers, contractors, partners and any others who provide services to us or you, perform functions on our behalf, or whom we enter into commercial collaboration with) for or in connection with the purposes for which such third parties are engaged, to perform certain disclosure to the relevant third parties which are technically required to process your transaction or for the purposes of our collaboration with such third parties (as the case may be), which may include allowing such third parties to introduce or offer products or services to you, authenticate you or connect with your Account, or conducting other activities including marketing, research, analysis and product development; and</li>
                                            <li>where we share Personal Information with affiliates, we will do so for the purpose of them helping us to provide the Application, to operate our business (including, where you have subscribed to our mailing list, for direct marketing purposes), or for the purpose of them conducting data processing on our behalf. For example, a temanQu Affiliate in another country may process and/or store your Personal Information on behalf of the temanQu group company in your country. All of our affiliates are committed to processing the Personal Information that they receive from us in line with this Privacy Policy and applicable law.</li>
                                        </ul>
                                    </li>
                                    <li>Where it is not necessary for the Personal Information to be associated with you, we will use reasonable endeavors to remove the means by which the Personal Information can be associated with you as an individual before disclosing or sharing such information.</li>
                                    <li>We will not sell or lease your Personal Information.</li>
                                    <li>Other than as provided for in this Privacy Policy, we may disclose or share your Personal Information if we notify you and we have obtained your consent for the disclosure or sharing.</li>
                                </ul>
                            </div>
						</div>
					</div>
                    <div class="accordion-item">
						<h2 class="accordion-header" id="headingFour">
						    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
						        <strong>Retention of Personal Information</strong>
						    </button>
						</h2>
						<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
						    <div class="accordion-body">	
                                <ul>
                                    <li>Your Personal Information will only be held for as long as it is necessary to fulfill the purpose for which it was collected, or for as long as such retention is required or authorized by Applicable Law. We shall cease to retain Personal Information, or remove the means by which the Personal Information can be associated with you as an individual, as soon as it is reasonable to assume that the purpose for which that Personal Information was collected is no longer being served by retention of Personal Information and retention is no longer necessary for legal or business purposes.</li>
                                    <li>Please note that there is still the possibility that some of your Personal Information might be retained by the other party, including by the government institutions in some manner. In the event we share your Personal Information to the authorized government institutions and/or other institutions that may be appointed by the government authorities or have a cooperation with us, you agree and acknowledge that the retention of your Personal Information by the relevant institutions will follow their respective policy on data retention. Information relayed through communications between users, service providers made other than through the use of the Application (such as by telephone calls, SMS, mobile messaging or other method of communication and collection of your Personal Information by our agent) may also be retained by some means. We do not encourage the retention of Personal Information by such means and we have no responsibility to you for the same. We shall not be liable for any such retention of your Personal Information. You agree to indemnify, defend and release us, our officers, directors, employees, agents, partners, suppliers, contractors and Affiliates from and against any and all claims, losses, liabilities, expenses, damages and costs (including but not limited to legal costs and expenses on a full indemnity basis) resulting directly or indirectly from any unauthorized retention of your Personal Information.</li>
                                </ul>
                            </div>
						</div>
					</div>
                    <div class="accordion-item">
						<h2 class="accordion-header" id="headingFive">
						    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
						        <strong>Access and correction of Personal Information</strong>
						    </button>
						</h2>
						<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
						    <div class="accordion-body">	
                                <ol Type="a">
                                    <li>Subject to the applicable law, you may request us for access to and/or the correction of your Personal Information in our possession and control, by contacting us at the details provided below.</li>
                                    <li>We reserve the right to refuse your requests for access to, or to correct, some or all of your Personal Information in our possession or control if permitted or required under any applicable law. This may include circumstances where the Personal Information may contain references to other individuals or where the request for access or request to correct is for reasons which we reasonably consider to be trivial, frivolous or vexatious.</li>
                                </ol>
                            </div>
						</div>
					</div>
                    <div class="accordion-item">
						<h2 class="accordion-header" id="headingSix">
						    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
						        <strong>Where we store your Personal Information</strong>
						    </button>
						</h2>
						<div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
						    <div class="accordion-body">	
                                <ol Type="a">
                                    <li>When you are using our Application and services in other countries where our Application is also accessible (“<strong>Designated Country</strong>”), we may transfer your Personal Information from the origin country (“<strong>Origin Country</strong>”) to the Designated Country in order to enable and ensure smooth customer experience when you are using our Application abroad. In such case, we will ask for your consent to transfer your Personal Data from the Origin Country to the Designated Country in order to ensure compliance to the applicable laws and regulations.</li>
                                    <li>Your Personal Information may also be stored or processed outside of your country by our personnel who work for us in other countries, or by our third-party service providers, vendors, suppliers, partners, contractors or Affiliates.</li>
                                    <li>We will comply with the applicable laws and regulations and use all reasonable endeavors to ensure that our Affiliates abroad and all such third-party service providers provide a level of protection that is comparable to our commitments under this Privacy Policy.</li>
                                </ol>
                            </div>
						</div>
					</div>
                    <div class="accordion-item">
						<h2 class="accordion-header" id="headingSeven">
						    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
						        <strong>Security of your Personal Information</strong>
						    </button>
						</h2>
						<div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
						    <div class="accordion-body">	
                            <p>Confidentiality of your Personal Information is of utmost importance to us. We will use all reasonable efforts to protect and secure your Personal Information against access, collection, use or disclosure by unauthorized persons and against unlawful processing, accidental loss, destruction and damage or similar risks. Unfortunately, the transmission of information via the Internet is not completely secure. Although we will do our best to protect your Personal Information, you acknowledge that we cannot guarantee the integrity and accuracy of any Personal Information which you transmit over the Internet, nor guarantee that such Personal Information would not be intercepted, accessed, disclosed, altered or destroyed by unauthorized third parties, due to factors beyond our control. You are responsible for keeping your account details confidential and you must not share your account details, including your password and One Time Password (OTP), with anyone and you must always maintain and fully responsible for the security of the device that you use.</p>
                            </div>
						</div>
					</div>
                    <div class="accordion-item">
						<h2 class="accordion-header" id="headingEight">
						    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
						        <strong>Changes to this Privacy Policy</strong>
						    </button>
						</h2>
						<div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
						    <div class="accordion-body">	
                            <p>We may review and amend this Privacy Policy at our sole discretion from time to time, to ensure that it is consistent with our future developments, and/or changes in legal or regulatory requirements. If we decide to amend this Privacy Policy, we will notify you of any such amendments by means of a general notice published on the Application and/or website, or otherwise to your e-mail address set out in your account. You agree that it is your responsibility to review this Privacy Policy regularly for the latest information on our data processing and data protection practices, and that your continued use of the Application or website, communications with us, or access to and use of the services following any amendments to this Privacy Policy will constitute your acceptance to this Privacy Policy and all of its amendments.</p>
                            </div>
						</div>
					</div>
                    <div class="accordion-item">
						<h2 class="accordion-header" id="headingNine">
						    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
						        <strong>Acknowledgment and consent</strong>
						    </button>
						</h2>
						<div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionExample">
						    <div class="accordion-body">	
                                <ol Type="a">
                                    <li>By accepting the Privacy Policy, you acknowledge that you have read and understood this Privacy Policy and you accept all of its terms. In particular, you agree and consent to us collecting, using, sharing, disclosing, storing, transferring, or otherwise processing your Personal Information in accordance with this Privacy Policy.</li>
                                    <li>In circumstances where you provide us with Personal Information relating to other individuals (such as Personal Information relating to your spouse, family members, friends, or other parties), you represent and warrant that you have obtained such individual’s consent for, and hereby consent on behalf of such individual to, the collection, use, disclosure and processing of his/her Personal Information by us.</li>
                                    <li>You may withdraw your consent to any or all collection, use or disclosure of your Personal Information at any time by giving us reasonable notice in writing using the contact details stated below. You may also withdraw your consent for us to send you certain communications and information via any “opt-out” or “unsubscribe” facility contained in our messages to you. Depending on the circumstances and the nature of the consent which you are withdrawing, you must understand and acknowledge that after such withdrawal of consent, you may no longer be able to use the Application or services. A withdrawal of consent by you may result in the termination of your account or of your contractual relationship with us, with all accrued rights and obligations remaining fully reserved. Upon receipt of your notice to withdraw consent for any collection, use or disclosure of your Personal Information, we will inform you of the likely consequences of such withdrawal so that you can decide if indeed you wish to withdraw consent.</li>
                                </ol>
                            </div>
						</div>
					</div>
                    <div class="accordion-item">
						<h2 class="accordion-header" id="headingTen">
						    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
						       <strong>Marketing and promotional material</strong>
						    </button>
						</h2>
						<div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#accordionExample">
						    <div class="accordion-body">	
                                <p>We and our partners may send you direct marketing, advertisement, and promotional communications via push-notification app, message in Application, post, telephone call, short message service (SMS), chat platform, social media, Chat Platform and Social Media, and e-mail (“<strong>Marketing Materials</strong>”) if you have agreed to subscribe to our mailing list, and/or consented to receive marketing and promotional materials from us. You may opt out from receiving such marketing communications at any time by clicking on any “unsubscribe” facility embedded in the relevant message, or otherwise contacting us using the contact details stated below. Please note that if you opt out, we may still send you non-promotional messages, such as ride receipts or information about your account.</p>
                            </div>
						</div>
					</div>
                    <div class="accordion-item">
						<h2 class="accordion-header" id="heading11">
						    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
						        <strong>Anonymous Data</strong>
						    </button>
						</h2>
						<div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11" data-bs-parent="#accordionExample">
						    <div class="accordion-body">	
                                <p>We may create, use, license or disclose Personal Information, provided, however, (i) that all identifiers have been removed such that the data, alone or in combination with other available data, cannot be attributed to or associated with or cannot identify any person, and (ii) that has been combined with similar data such that the original data forms a part of a larger data set.</p>
                            </div>
						</div>
					</div>
                    <div class="accordion-item">
						<h2 class="accordion-header" id="heading12">
						    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
						        <strong>Third party platforms</strong>
						    </button>
						</h2>
						<div id="collapse12" class="accordion-collapse collapse" aria-labelledby="heading12" data-bs-parent="#accordionExample">
						    <div class="accordion-body">	
                                <ol Type="a">
                                    <li>The Application, website, and Marketing Materials may contain links to websites that are operated by third parties. We do not control nor accept liability or responsibility for these websites and for the collection, use, maintenance, sharing, or disclosure of data and information by such third parties. Please consult the terms and conditions and privacy policies of those third-party websites to find out how they collect and use your Personal Information.</li>
                                    <li>When you are using our Application and enable the fingerprints and/or facial recognition features in your mobile device for authentication purposes, please note that we do not store such biometric data. Unless otherwise notified to you, such data is stored in your mobile device and may also be stored by third parties, such as your device’s manufacturer. You agree and acknowledge that we are not responsible for any unauthorized access or loss towards such biometric data which is stored in your mobile device.</li>
                                    <li>Advertisements contained on our Application, website, or Marketing Materials operate as links to the advertiser’s website and as such any information they collect by virtue of your clicking on that link will be collected and used by the relevant advertiser in accordance with the privacy policy of that advertiser.</li>
                                </ol>
                            </div>
						</div>
					</div>
                    <div class="accordion-item">
						<h2 class="accordion-header" id="heading13">
						    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse13" aria-expanded="false" aria-controls="collapse13">
						        <strong>How to contact us</strong>
						    </button>
						</h2>
						<div id="collapse13" class="accordion-collapse collapse" aria-labelledby="heading13" data-bs-parent="#accordionExample">
						    <div class="accordion-body">	
                                <p>If you have any questions regarding this Privacy Policy or you would like to obtain access to your Personal Information, please contact dpo-id@temanqu.id.
                                <br>For other questions or complaints, you can contact us via email or telephone at the following contacts:</p>                            
                                <ul>
                                    <li>email	:	cs@temanqu.id</li>
                                    <li>Call 	:	+62 811 9001 9999</li>
                                </ul>
                            </div>
						</div>
					</div>
                </div>
           </div>
        </section>
        <!-- home-agency end -->

        <!-- footer & cta start -->
        <section class="footer bg-light">
            <!-- <div class="cta-content">
                <div class="container">
                    <div class="row bg-dark cta-bg p-5 rounded align-items-center">
                        <div class="col-lg-6">
                            <h3 class="text-white fs-26 mb-3">Subscribe our newsletter</h3>
                            <p class="text-white opacity-75 mb-4 mb-lg-0">Et harum quidem rerum facilis est us et expedita distinctio am libero tempore cum soluta nobis.</p>
                        </div>
                        <div class="col-lg-5 offset-lg-1">
                            <div class="subscribe-form">
                                <i class="mdi mdi-email-outline form-icon"></i>
                                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Enter Email Address" />
                                <a href="{{ url('themes/dojek') }}/javascript:void(0);" class="btn btn-primary form-btn">Get Access</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="container">
                <div class="row">
                    <!-- <div class="col-lg-3 text-center text-lg-start">
                        <div class="footer-logo mb-4">
                            <a href="{{ url('/') }}/#">
                                <img src="{{ url( env('APP_LOGO') ) }}" alt="" height="50">
                            </a>
                        </div>
                        <a href="{{ url('themes/dojek') }}/#" class="text-muted">Hello@coderthemes.com</a>
                        <p class="text-muted">+01 ( 1234 567 890 )</p> -->
                        <div class="col-sm-6 col-md-3">        
                            <ul class="list-unstyled footer-nav">
                                    <li><a href="{{ url('/company/privacy-policy') }}" class="footer-link">Privacy Policy</a>
                                </li>                                
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="col-lg-9">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <h5 class="fs-22 mb-3 fw-semibold">About Us</h5>
                                <ul class="list-unstyled footer-nav">
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Support Center</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Customer Support</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">About Us</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Copyright</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Popular Campaign</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <h5 class="fs-22 mb-3 fw-semibold">Our Information</h5>
                                <ul class="list-unstyled footer-nav">
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Return Policy</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Privacy Policy</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Terms & Conditions</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Site Map</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Store Hours</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <h5 class="fs-22 mb-3 fw-semibold">My Account</h5>
                                <ul class="list-unstyled footer-nav">
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Press Inquiries</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Social Media Directories</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Images & B-roll</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Permissions</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Speaker Requests</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <h5 class="fs-22 mb-3 fw-semibold">Policy</h5>
                                <ul class="list-unstyled footer-nav">
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Application Security</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Softwere Principles</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Unwanted Softwere Policy</a></li>
                                    <li><a href="{{ url('themes/dojek') }}/javascript:void(0);" class="footer-link">Risponsible Supply Chain</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </section>
        <!-- footer & cta end -->

        <!-- Back to top -->
        <a href="{{ url('themes/dojek') }}/#" onclick="topFunction()" class="back-to-top-btn btn btn-dark" id="back-to-top"><i class="mdi mdi-chevron-up"></i></a>

        <!-- javascript -->
        <script src="{{ url('themes/dojek') }}/js/bootstrap.bundle.min.js"></script>
        <!-- Portfolio filter -->
        <script src="{{ url('themes/dojek') }}/js/filter.init.js"></script>
        <!-- Light-box -->
        <script src="{{ url('themes/dojek') }}/js/mklb.js"></script>
        <!-- swiper -->
        <script src="{{ url('themes/dojek') }}/js/swiper-bundle.min.js"></script>
        <script src="{{ url('themes/dojek') }}/js/swiper.js"></script>

        <!-- counter -->
        <script src="{{ url('themes/dojek') }}/js/counter.init.js"></script>
        <script src="{{ url('themes/dojek') }}/js/app.js"></script>
    </body>
</html>
