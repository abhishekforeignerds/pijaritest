@extends('frontend.layouts.app')
@section('content')

@section('meta')
    <title>About Pujari Ji</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection
<section class="about-section">
    <div class="auto-container">
        <div class="row align-items-center">
            <div class="content-column col-xl-6 col-lg-6 order-lg-2 wow fadeInRight" data-wow-delay="600ms">
                <div class="inner-column">
                    @if (session()->get('pooja_language') == 'English')
                        <div class="sec-title">
                            <span class="sub-title">{{ env('APP_NAME') }}</span>
                            <h2>Founder Message.</h2>
                            <div class="text">
                                <p><b>Namaste</b></br>At {{ env('APP_NAME') }} our journey began with a vision to bring
                                    spirituality closer to your everyday life by making authentic Pandit Ji services and
                                    Pooja rituals accessible at your fingertips. In today’s fast-paced world, where
                                    traditions often get sidelined, we recognized the need for a reliable platform that
                                    bridges the gap between ancient rituals and modern lifestyles.</p>
                                <p>Our mission is to ensure that every individual, regardless of their location, can
                                    experience the sanctity and blessings of traditional Poojas, whether at home or in a
                                    temple. By collaborating with experienced and knowledgeable Pandits, we are
                                    committed to
                                    upholding the authenticity of our rich cultural and spiritual heritage. </p>
                                <p>We believe that spirituality is not bound by borders or limitations, and through our
                                    platform, we aspire to make every sacred ceremony meaningful, convenient, and
                                    accessible. Thank you for trusting us to be part of your spiritual journey. We are
                                    honored to serve you and contribute to preserving the timeless traditions that bring
                                    peace, harmony, and positivity into our lives. </p>
                                <p class="font-italic"><b>Warm regards,</b><br><b>Acharya Dharmesh Upadhyay
                                    </b><br>Founder
                                    <b>{{ env('APP_NAME') }}</b>
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="sec-title">
                            <span class="sub-title">{{ env('APP_NAME') }}</span>
                            <h2>संस्थापक का संदेश</h2>
                            <div class="text">
                                <p><b>नमस्ते</b></br>{{ env('APP_NAME') }} में हमारी यात्रा एक दृष्टि के साथ शुरू हुई कि
                                    आपकी रोज़मर्रा की
                                    जिंदगी में आध्यात्म को करीब लाया जा सके, जिससे प्रामाणिक पंडित जी सेवाएं और पूजन
                                    विधियां आपकी उंगलियों
                                    पर सुलभ हों। आज की तेज़-रफ्तार दुनिया में, जहां परंपराएं अक्सर पीछे छूट जाती हैं,
                                    हमने प्राचीन
                                    विधियों और आधुनिक जीवनशैली के बीच एक पुल बनाने की आवश्यकता को महसूस किया।</p>
                                <p>हमारा मिशन यह सुनिश्चित करना है कि हर व्यक्ति, चाहे वह कहीं भी हो, पारंपरिक पूजाओं की
                                    पवित्रता
                                    और आशीर्वाद का अनुभव कर सके, चाहे वह घर पर हो या मंदिर में। अनुभवी और जानकार पंडितों
                                    के साथ
                                    सहयोग करके, हम अपनी समृद्ध सांस्कृतिक और आध्यात्मिक धरोहर की प्रामाणिकता को बनाए
                                    रखने के लिए
                                    प्रतिबद्ध हैं।</p>
                                <p>हम मानते हैं कि आध्यात्म सीमाओं या बाधाओं में बंधा नहीं है, और हमारे प्लेटफार्म के
                                    माध्यम से
                                    हम हर पवित्र समारोह को अर्थपूर्ण, सुविधाजनक और सुलभ बनाने की आकांक्षा रखते हैं। हमें
                                    आपके
                                    आध्यात्मिक यात्रा का हिस्सा बनने का विश्वास दिलाने के लिए धन्यवाद। हमें गर्व है कि
                                    हम आपको सेवा
                                    प्रदान कर सकते हैं और उन शाश्वत परंपराओं को संरक्षित करने में योगदान दे सकते हैं जो
                                    हमारे जीवन
                                    में शांति, सामंजस्य और सकारात्मकता लाती हैं।</p>
                                <p class="font-italic"><b>सादर,</b><br><b>आचार्य धर्मेश उपाध्याय</b><br>संस्थापक
                                    <b>{{ env('APP_NAME') }}</b>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="wow fadeInLeft">
                    <figure class="image-2 overlay-anim wow fadeInLeft">
                        <img src="{{ asset('frontend/assets/images/founder.jpg') }}">
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="vision-mission">
    <div class="auto-container">
        <div class="row align-items-center">
            <div class="col-md-2 text-center  d-none d-xl-block d-md-none">
                <img src="{{ asset('frontend/assets/images/puja.png') }}">
            </div>
            @if (session()->get('pooja_language') == 'English')
                <div class="col-md-10">
                    <h5>Vision</h5>
                    <p>To become the most trusted and accessible platform for connecting individuals with qualified and
                        experienced Pandit Ji for all spiritual, religious, and cultural needs, fostering devotion and
                        tradition in every household.</p>
                </div>
                <div class="col-md-2 text-center d-none d-xl-block d-md-none">
                    <img src="{{ asset('frontend/assets/images/puja.png') }}">
                </div>
                <div class="col-md-10">
                    <h5>Mission</h5>
                    <p>Our mission is to provide a seamless and accessible platform that connects devotees with
                        authentic
                        and experienced Pandit Ji services for both home and temple rituals. By integrating technology
                        with
                        tradition, we aim to simplify the process of booking spiritual ceremonies while preserving the
                        cultural and spiritual heritage of Indian rituals. We are committed to ensuring authenticity
                        through
                        partnerships with certified Pandits, offering personalized solutions for diverse religious
                        needs,
                        and fostering a sense of devotion and community. Through transparent services, flexible options,
                        and
                        comprehensive guidance, we strive to make spiritual practices meaningful and convenient for
                        everyone, anywhere in the world. </p>
                </div>
            @else
                <div class="col-md-10">
                    <h5>दृष्टि</h5>
                    <p>हर व्यक्ति को उनके आध्यात्मिक, धार्मिक और सांस्कृतिक जरूरतों के लिए योग्य और अनुभवी पंडित जी से
                        जोड़ने
                        के लिए सबसे भरोसेमंद और सुलभ प्लेटफॉर्म बनना, और हर घर में भक्ति और परंपरा को बढ़ावा देना।</p>
                </div>
                <div class="col-md-2 text-center d-none d-xl-block d-md-none">
                    <img src="{{ asset('frontend/assets/images/puja.png') }}">
                </div>
                <div class="col-md-10">
                    <h5>मिशन</h5>
                    <p>हमारा मिशन एक सहज और सुलभ प्लेटफॉर्म प्रदान करना है जो भक्तों को प्रामाणिक और अनुभवी पंडित जी
                        सेवाओं
                        से जोड़ता है, चाहे वह घर में हो या मंदिर में। प्रौद्योगिकी और परंपरा को जोड़कर, हमारा उद्देश्य
                        आध्यात्मिक
                        समारोहों की बुकिंग की प्रक्रिया को सरल बनाना है, जबकि भारतीय धार्मिक परंपराओं की सांस्कृतिक और
                        आध्यात्मिक
                        धरोहर को संरक्षित रखना है। हम प्रमाणित पंडितों के साथ साझेदारी के माध्यम से प्रामाणिकता
                        सुनिश्चित करने,
                        विभिन्न धार्मिक जरूरतों के लिए व्यक्तिगत समाधान प्रदान करने, और भक्ति और सामुदायिक भावना को
                        बढ़ावा देने
                        के लिए प्रतिबद्ध हैं। पारदर्शी सेवाओं, लचीले विकल्पों और व्यापक मार्गदर्शन के माध्यम से, हम हर
                        किसी के लिए,
                        दुनिया में कहीं भी, आध्यात्मिक प्रथाओं को अर्थपूर्ण और सुविधाजनक बनाना चाहते हैं।</p>
                </div>
            @endif
        </div>
    </div>
</section>

<section class="about-section">
    <div class="auto-container">
        <div class="row align-items-center">
            <div class="content-column col-xl-6 col-lg-6 wow fadeInRight" data-wow-delay="600ms">
                <div class="inner-column">
                    @if (session()->get('pooja_language') == 'English')
                        <div class="sec-title">
                            <span class="sub-title">{{ env('APP_NAME') }}</span>
                            <h2>Co-Founder Message.</h2>
                            <div class="text">
                                <p><br>Acharya Sumitranandan Chaturvedi ji has also received education from Sampurnanand
                                    Sanskrit University and he has been a gold medalist of this university. He has also
                                    qualified the NET exam and served as Assistant Acharya in the Pran Pratistha of Shri
                                    Ram
                                    Temple, Ayodhya.</p>
                                <p>His dedication to Hinduism and his commitment towards the upliftment of scriptures
                                    and
                                    Sanskrit make him unique. Their aim is to perform all the religious rituals and
                                    traditions of Sanatan Dharma as per Vedic methods and scriptures. </p>
                                <p class="font-italic"><b>Warm regards,</b><br><b>Acharya Sumitranandan Chaturvedi ji
                                    </b><br>Co-Founder <b>{{ env('APP_NAME') }}</b></p>
                            </div>
                        </div>
                    @else
                        <div class="sec-title">
                            <span class="sub-title">{{ env('APP_NAME') }}</span>
                            <h2>सह-संस्थापक का संदेश</h2>
                            <div class="text">
                                <p><br>आचार्य सुमित्रानंदन चतुर्वेदी जी ने सम्पूर्णानंद संस्कृत विश्वविद्यालय से शिक्षा
                                    प्राप्त की है और
                                    वह इस विश्वविद्यालय के स्वर्ण पदक विजेता रह चुके हैं। उन्होंने NET परीक्षा उत्तीर्ण
                                    की है और
                                    श्री राम मंदिर, अयोध्या में प्राण प्रतिष्ठा के दौरान सहायक आचार्य के रूप में सेवा दी
                                    है।</p>
                                <p>हिंदू धर्म के प्रति उनकी निष्ठा और शास्त्रों एवं संस्कृत के उत्थान के लिए उनकी
                                    प्रतिबद्धता
                                    उन्हें विशेष बनाती है। उनका लक्ष्य वैदिक विधियों और शास्त्रों के अनुसार सनातन धर्म
                                    के सभी धार्मिक
                                    अनुष्ठानों और परंपराओं का निर्वहन करना है।</p>
                                <p class="font-italic"><b>सादर,</b><br><b>आचार्य सुमित्रानंदन चतुर्वेदी
                                        जी </b>
                                    <br>
                                    सह-संस्थापक
                                    <b>{{ env('APP_NAME') }}</b>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="inner-column wow fadeInLeft">
                    <figure class="image-2 overlay-anim wow fadeInLeft">
                        <img src="{{ asset('frontend/assets/images/about-pujari-ji.jpg') }}">
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
