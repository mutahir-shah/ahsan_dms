<?php

namespace App\Traits;

use App\CancellationReason;
use App\Language;
use App\Onboarding;
use Illuminate\Support\Facades\DB;

trait OnboardingTrait
{

    public function storeOnboardings()
    {
        $onboardings = (object)$this->getOnboardings();
        Onboarding::truncate();
        $languages = Language::all();

        DB::table('language_translations')->where('translationable_type', 'App\Onboarding')->delete();

        foreach($onboardings as $onboarding){
            if($onboarding['language_id'] == 1){
                $newOnBoarging = Onboarding::create($onboarding);
            }
            foreach($languages as $language){
                if($language->id == $onboarding['language_id']){
                    $newOnBoarging->translations()->create([
                        'name' => $onboarding['title'],
                        'description' => $onboarding['description'],
                        'language_id' => $language->id,
                    ]);
                }
            }
        }
    }

    public function getOnboardings()
    {
        return [
            [
                'language_id' => 1,
                'parent_id' => 0,
                'step' => 1,
                'title' => 'Pick Your Destination',
                'description' => 'Let available drivers know where you are and where you’re headed.',
                'type' => 'DRIVER',
                'image' => 'https://dev.meemcolart.com/storage/website/7Dd6UuKr195trpq9nwzbv4cpjoc3DgOciNClF1EU.jpeg'
            ],
            [
                'language_id' => 2,
                'title' => 'Alege-ți Destinația',
                'description' => 'Informați șoferii disponibili unde vă aflați și încotro vă îndreptați.',
            ],
            [
                'language_id' => 3,
                'title' => 'اختر وجهتك',
                'description' => 'أخبر السائقين المتاحين بمكان تواجدك والمكان الذي تتجه إليه.',
            ],
            [
                'language_id' => 4,
                'title' => 'Välj din destination',
                'description' => 'Låt tillgängliga förare veta var du är och vart du är på väg.'
            ],
            [
                'language_id' => 5,
                'title' => 'Elige tu destino',
                'description' => 'Informe a los conductores disponibles dónde se encuentra y hacia dónde se dirige.'
            ],
            [
                'language_id' => 6,
                'title' => 'Choisissez votre destination',
                'description' => 'Faites savoir aux conducteurs disponibles où vous êtes et où vous allez.'
            ],
            [
                'language_id' => 7,
                'title' => 'Wybierz miejsce docelowe',
                'description' => 'Poinformuj dostępnych kierowców, gdzie się znajdujesz i dokąd zmierzasz.'
            ],
            [
                'language_id' => 8,
                'title' => 'Valitse määränpääsi',
                'description' => 'Kerro käytettävissä oleville kuljettajille, missä olet ja minne olet menossa.'
            ],
            [
                'language_id' => 9,
                'title' => 'Dooro Meeshaada',
                'description' => 'U sheeg darawalada la heli karo halka aad joogto iyo meesha aad u socoto.'
            ],
            [
                'language_id' => 10,
                'title' => 'आफ्नो गन्तव्य छान्नुहोस्',
                'description' => 'उपलब्ध ड्राइभरहरूलाई थाहा दिनुहोस् कि तपाईं कहाँ हुनुहुन्छ र तपाईं कहाँ जाँदै हुनुहुन्छ।'
            ],
            [
                'language_id' => 11,
                'title' => 'Chagua Unakoenda',
                'description' => 'Waruhusu madereva wanaopatikana wajue ulipo na unapoelekea.'
            ],
            [
                'language_id' => 12,
                'title' => 'Выберите пункт назначения',
                'description' => 'Сообщите доступным водителям, где вы находитесь и куда направляетесь.'
            ],
            [
                'language_id' => 13,
                'title' => '選擇您的目的地',
                'description' => '讓可用的司機知道您在哪裡以及您要去哪裡。'
            ],
            [
                'language_id' => 1,
                'parent_id' => 0,
                'step' => 1,
                'title' => 'Your RideSafe Driver Arrives.',
                'description' => 'Check the driver matches their selfie before getting in. You can message and call them through the RideSafe app if needed.',
                'type' => 'DRIVER',
                'image' => 'https://dev.meemcolart.com/storage/website/AmDmlqdwHEYQ2PYHP0nqaYdsw6PmFe6H6NSYYask.jpeg'
            ],
            [
                'language_id' => 2,
                'title' => 'Sosește șoferul dumneavoastră RideSafe.',
                'description' => 'Verificați dacă șoferul se potrivește cu selfie-ul înainte de a intra. Puteți să îi trimiteți mesaje și să-i sunați prin aplicația RideSafe, dacă este necesar.',
            ],
            [
                'language_id' => 3,
                'title' => 'وصل سائق RideSafe الخاص بك.',
                'description' => 'تأكد من تطابق صورة السائق مع صورته الشخصية قبل الركوب. يمكنك إرسال رسالة إليه أو الاتصال به عبر تطبيق RideSafe إذا لزم الأمر.',
            ],
            [
                'language_id' => 4,
                'title' => 'Din RideSafe-förare anländer.',
                'description' => 'Kontrollera att föraren matchar deras selfie innan du går in. Du kan skicka meddelanden och ringa dem via RideSafe-appen om det behövs.',
            ],
            [
                'language_id' => 5,
                'title' => 'Llega tu conductor de RideSafe.',
                'description' => 'Comprueba que el conductor coincida con su selfie antes de subir. Puedes enviarle mensajes y llamarlo a través de la aplicación RideSafe si es necesario.',
            ],
            [
                'language_id' => 6,
                'title' => 'Votre chauffeur RideSafe arrive.',
                'description' => 'Vérifiez que le conducteur correspond à son selfie avant de monter. Vous pouvez leur envoyer un message et les appeler via l\'application RideSafe si nécessaire.',
            ],
            [
                'language_id' => 7,
                'title' => 'Przyjeżdża Twój kierowca RideSafe.',
                'description' => 'Sprawdź, czy kierowca pasuje do swojego selfie, zanim wsiądziesz. W razie potrzeby możesz wysłać do niego wiadomość lub zadzwonić za pomocą aplikacji RideSafe.',
            ],
            [
                'language_id' => 8,
                'title' => 'RideSafe-kuljettajasi saapuu.',
                'description' => 'Tarkista, että kuljettaja vastaa hänen selfie-kuvaansa ennen kuin astut sisään. Voit lähettää hänelle viestin ja soittaa tarvittaessa RideSafe-sovelluksen kautta.',
            ],
            [
                'language_id' => 9,
                'title' => 'Darawalka RideSafe ayaa imaanaya',
                'description' => 'Hubi in darawalku uu ku habboon yahay sawirkiisa ka hor inta aanad gudaha gelin. Waxaad farriin u diri kartaa oo ka wici kartaa app-ka RideSafe haddii loo baahdo.',
            ],
            [
                'language_id' => 10,
                'title' => 'तपाईंको राइडसेफ ड्राइभर आइपुग्छ।',
                'description' => 'भित्र पस्नु अघि चालकले उनीहरूको सेल्फीसँग मेल खान्छ भनी जाँच गर्नुहोस्। आवश्यक परेमा तपाईंले RideSafe एप मार्फत सन्देश पठाउन र कल गर्न सक्नुहुन्छ।',
            ],
            [
                'language_id' => 11,
                'title' => 'Dereva wako wa RideSafe Anawasili.',
                'description' => 'Angalia kiendeshi kinalingana na selfie yake kabla ya kuingia. Unaweza kutuma ujumbe na kumpigia simu kupitia programu ya RideSafe ikihitajika.',
            ],
            [
                'language_id' => 12,
                'title' => 'Прибывает ваш водитель RideSafe.',
                'description' => 'Прежде чем сесть в машину, проверьте, соответствует ли водитель своему селфи. При необходимости вы можете отправить ему сообщение или позвонить через приложение RideSafe.',
            ],
            [
                'language_id' => 13,
                'title' => '您的 RideSafe 司機來了。',
                'description' => '上車前檢查司機是否與他們的自拍照相符。',
            ],
            [
                'language_id' => 1,
                'parent_id' => 0,
                'step' => 1,
                'title' => 'Enjoy Your Journey',
                'description' => 'Busy tonight drive? Lovely weather we’re having!',
                'type' => 'DRIVER',
                'image' => 'https://dev.meemcolart.com/storage/website/hRSn8DH9XKHyUO4XNjUyo1oKdFD5Tmd4fpSs63sC.jpeg'
            ],
            [
                'language_id' => 2,
                'title' => 'Bucură-te de călătoria ta',
                'description' => 'Ocupat cu mașina în seara asta? Vreme minunată avem!',
            ],
            [
                'language_id' => 3,
                'title' => 'استمتع برحلتك',
                'description' => 'هل أنت مشغول بالقيادة الليلة؟ الطقس جميل!',
            ],
            [
                'language_id' => 4,
                'title' => 'Njut av din resa',
                'description' => 'Upptagen med bilresan ikväll? Härligt väder vi har!',
            ],
            [
                'language_id' => 5,
                'title' => 'Disfruta tu viaje',
                'description' => '¿Esta noche vas a conducir con mucho tráfico? ¡Hace un tiempo precioso!',
            ],
            [
                'language_id' => 6,
                'title' => 'Profitez de votre voyage',
                'description' => 'Vous êtes occupés ce soir ? Nous avons un temps magnifique !',
            ],
            [
                'language_id' => 7,
                'title' => 'Ciesz się podróżą',
                'description' => 'Zajęci dziś wieczorem jazdą? Mamy piękną pogodę!',
            ],
            [
                'language_id' => 8,
                'title' => 'Nauti matkastasi',
                'description' => 'Oletko kiireinen tänä iltana? Ihana sää meillä!',
            ],
            [
                'language_id' => 9,
                'title' => 'Ku raaxayso safarkaaga',
                'description' => 'Mashquulsan tahay caawa baabuur? Cimilo qurxoon ayaanu ku jirnaa!',
            ],
            [
                'language_id' => 10,
                'title' => 'तपाईंको यात्राको आनन्द लिनुहोस्',
                'description' => 'व्यस्त आज राती ड्राइभ? हामीसँग राम्रो मौसम छ!',
            ],
            [
                'language_id' => 11,
                'title' => 'Furahia Safari Yako',
                'description' => 'Je, una shughuli nyingi za kuendesha gari usiku wa leo? Hali ya hewa nzuri tunayo!',
            ],
            [
                'language_id' => 12,
                'title' => 'Приятного путешествия',
                'description' => 'Заняты сегодня вечером? У нас прекрасная погода!',
            ],
            [
                'language_id' => 13,
                'title' => '享受你的旅程',
                'description' => '今晚開車忙嗎？我們的天氣真好！',
            ],
            [
                'language_id' => 1,
                'parent_id' => 0,
                'step' => 1,
                'title' => 'You’ve Arrived',
                'description' => 'Arrive safely at your destination.',
                'type' => 'DRIVER',
                'image' => 'https://dev.meemcolart.com/storage/website/UQiFwVqnNhxUsVpUaLM5ruCwbhLKZxwD8rILLAgG.jpeg'
            ],
            [
                'language_id' => 2,
                'title' => 'Ai sosit',
                'description' => 'Ajunge în siguranță la destinație.',
            ],
            [
                'language_id' => 3,
                'title' => 'لقد وصلت',
                'description' => 'الوصول بسلامة إلى وجهتك.',
            ],
            [
                'language_id' => 4,
                'title' => 'Du har anlänt',
                'description' => 'Kom säkert fram till din destination.',
            ],
            [
                'language_id' => 5,
                'title' => 'Has llegado',
                'description' => 'Llega sano y salvo a tu destino.',
            ],
            [
                'language_id' => 6,
                'title' => 'Vous êtes arrivés',
                'description' => 'Arrivez à destination en toute sécurité.',
            ],
            [
                'language_id' => 7,
                'title' => 'Dotarłeś',
                'description' => 'Dotrzyj bezpiecznie do celu.',
            ],
            [
                'language_id' => 8,
                'title' => 'Olet saapunut',
                'description' => 'Saavu turvallisesti määränpäähäsi.',
            ],
            [
                'language_id' => 9,
                'title' => 'Waad timid',
                'description' => 'Si nabad ah ku tag meeshaad u socoto.',
            ],
            [
                'language_id' => 10,
                'title' => 'तपाईं आइपुग्नु भएको छ',
                'description' => 'Arrive safely at your destination.',
            ],
            [
                'language_id' => 11,
                'title' => 'Umefika',
                'description' => 'Fika salama unakoenda.',
            ],
            [
                'language_id' => 12,
                'title' => 'Вы прибыли',
                'description' => 'Благополучно доберитесь до места назначения.',
            ],
            [
                'language_id' => 13,
                'title' => '您已抵達',
                'description' => '安全抵達目的地。',
            ],
            [
                'language_id' => 1,
                'parent_id' => 0,
                'step' => 1,
                'title' => 'Smooth Ride?',
                'description' => 'Let your driver know by leaving them a review!',
                'type' => 'DRIVER',
                'step' => 5,
                'image' => 'https://dev.meemcolart.com/storage/website/J2FRM3DLJDbmmE8iToot2JUV1AA4rdqWS4DEOyDu.png'
            ],
            [
                'language_id' => 2,
                'title' => 'Smooth Ride?',
                'description' => 'Anunțați șoferul dvs. lăsându-i o recenzie!',
            ],
            [
                'language_id' => 3,
                'title' => 'رحلة سلسة؟',
                'description' => 'أخبر سائقك بذلك عن طريق ترك تعليق له!',
            ],
            [
                'language_id' => 4,
                'title' => 'Smidig körning?',
                'description' => 'Låt din förare veta genom att lämna en recension!',
            ],
            [
                'language_id' => 5,
                'title' => '¿Viaje suave?',
                'description' => '¡Hazle saber a tu conductor dejándole una reseña!',
            ],
            [
                'language_id' => 6,
                'title' => 'Une conduite en douceur ?',
                'description' => 'Faites-le savoir à votre chauffeur en lui laissant un avis !',
            ],
            [
                'language_id' => 7,
                'title' => 'Gładka jazda?',
                'description' => 'Daj znać swojemu kierowcy i zostaw mu recenzję!',
            ],
            [
                'language_id' => 8,
                'title' => 'Smooth Ride?',
                'description' => 'Kerro kuljettajallesi jättämällä heille arvostelu!',
            ],
            [
                'language_id' => 9,
                'title' => 'Raadraac fudud?',
                'description' => 'U sheeg darawalkaaga adiga oo uga tagaya dib u eegis!',
            ],
            [
                'language_id' => 10,
                'title' => 'सहज सवारी?',
                'description' => 'आफ्नो चालकलाई एक समीक्षा छोडेर थाहा दिनुहोस्!',
            ],
            [
                'language_id' => 11,
                'title' => 'Usafiri Mlaini?',
                'description' => 'Mjulishe dereva wako kwa kuwaachia ukaguzi!',
            ],
            [
                'language_id' => 12,
                'title' => 'Плавный ход?',
                'description' => 'Сообщите об этом своему водителю, оставив ему отзыв!',
            ],
            [
                'language_id' => 13,
                'title' => '平穩行駛？',
                'description' => '給您的司機留下評論，讓他們知道！',
            ],
            [
                'language_id' => 1,
                'parent_id' => 0,
                'step' => 1,
                'title' => 'Choose Your Destination',
                'description' => 'Let available drivers know where you are and where you’re headed.',
                'type' => 'USER',
                'image' => 'https://dev.meemcolart.com/storage/website/K5qaLkBSUbRPm3JRyH1KXd0nnAVvIVTTHSGlTr0x.png'
            ],
            [
                'language_id' => 2,
                'title' => 'Alege-ți Destinația',
                'description' => 'Informați șoferii disponibili unde vă aflați și încotro vă îndreptați.',
            ],
            [
                'language_id' => 3,
                'title' => 'اختر وجهتك',
                'description' => 'أخبر السائقين المتاحين بمكان تواجدك والمكان الذي تتجه إليه.',
            ],
            [
                'language_id' => 4,
                'title' => 'Välj din destination',
                'description' => 'Låt tillgängliga förare veta var du är och vart du är på väg.',
            ],
            [
                'language_id' => 5,
                'title' => 'Elige tu destino',
                'description' => 'Informe a los conductores disponibles dónde se encuentra y hacia dónde se dirige.',
            ],
            [
                'language_id' => 6,
                'title' => 'Choisissez votre destination',
                'description' => 'Faites savoir aux conducteurs disponibles où vous êtes et où vous allez.',
            ],
            [
                'language_id' => 7,
                'title' => 'Wybierz miejsce docelowe',
                'description' => 'Poinformuj dostępnych kierowców, gdzie się znajdujesz i dokąd zmierzasz.',
            ],
            [
                'language_id' => 8,
                'title' => 'Valitse määränpääsi',
                'description' => 'Kerro käytettävissä oleville kuljettajille, missä olet ja minne olet menossa.',
            ],
            [
                'language_id' => 9,
                'title' => 'Dooro Meeshaada',
                'description' => 'U sheeg darawalada la heli karo halka aad joogto iyo meesha aad u socoto.',
            ],
            [
                'language_id' => 10,
                'title' => 'आफ्नो गन्तव्य छान्नुहोस्',
                'description' => 'उपलब्ध ड्राइभरहरूलाई थाहा दिनुहोस् कि तपाईं कहाँ हुनुहुन्छ र तपाईं कहाँ जाँदै हुनुहुन्छ।',
            ],
            [
                'language_id' => 11,
                'title' => 'Chagua Unakoenda',
                'description' => 'Waruhusu madereva wanaopatikana wajue ulipo na unapoelekea.',
            ],
            [
                'language_id' => 12,
                'title' => 'Выберите пункт назначения',
                'description' => 'Сообщите доступным водителям, где вы находитесь и куда направляетесь.',
            ],
            [
                'language_id' => 13,
                'title' => '選擇您的目的地',
                'description' => '讓可用的司機知道您在哪裡以及您要去哪裡。',
            ],
            [
                'language_id' => 1,
                'parent_id' => 0,
                'step' => 1,
                'title' => 'Your RideSafe Driver Arrives',
                'description' => 'Check the driver matches their selfie before getting in. You can message and call them through the RideSafe app if needed!',
                'type' => 'USER',
                'image' => 'https://dev.meemcolart.com/storage/website/dzYiWuruM6lPOy24Bo4ijUqq0Hq0IRZ7lycedLOa.png'
            ],
            [
                'language_id' => 2,
                'title' => 'Sosește șoferul dumneavoastră RideSafe',
                'description' => 'Verificați dacă șoferul se potrivește cu selfie-ul său înainte de a intra. Puteți să îi trimiteți un mesaj și să îi sunați prin aplicația RideSafe, dacă este necesar!',
            ],
            [
                'language_id' => 3,
                'title' => 'وصل سائق RideSafe الخاص بك',
                'description' => 'تأكد من أن صورة السائق تطابق صورته الشخصية قبل الركوب. يمكنك إرسال رسالة إليه أو الاتصال به عبر تطبيق RideSafe إذا لزم الأمر!',
            ],
            [
                'language_id' => 4,
                'title' => 'Din RideSafe-förare anländer',
                'description' => 'Kontrollera att föraren matchar deras selfie innan du går in. Du kan skicka meddelanden och ringa dem via RideSafe-appen om det behövs!',
            ],
            [
                'language_id' => 5,
                'title' => 'Llega tu conductor de RideSafe',
                'description' => 'Comprueba que el conductor coincida con su selfie antes de subir. ¡Puedes enviarle mensajes y llamarlo a través de la aplicación RideSafe si es necesario!',
            ],
            [
                'language_id' => 6,
                'title' => 'Votre chauffeur RideSafe arrive',
                'description' => 'Vérifiez que le conducteur correspond à son selfie avant de monter. Vous pouvez leur envoyer un message et les appeler via l\'application RideSafe si nécessaire !',
            ],
            [
                'language_id' => 7,
                'title' => 'Przyjeżdża Twój kierowca RideSafe',
                'description' => 'Sprawdź, czy kierowca pasuje do swojego selfie, zanim wsiądziesz. W razie potrzeby możesz wysłać do niego wiadomość lub zadzwonić za pomocą aplikacji RideSafe!',
            ],
            [
                'language_id' => 8,
                'title' => 'RideSafe-kuljettajasi saapuu',
                'description' => 'Tarkista, että kuljettaja vastaa selfie-kuvaansa ennen kuin astut sisään. Voit lähettää hänelle viestiä ja soittaa tarvittaessa RideSafe-sovelluksen kautta!',
            ],
            [
                'language_id' => 9,
                'title' => 'Darawalka RideSafe ayaa imaanaya',
                'description' => 'Hubi in dareewalka uu ku habboon yahay sawirkiisa ka hor inta aanad gudaha gelin. Waxaad farriin u diri kartaa oo aad ka wici kartaa app-ka RideSafe haddii loo baahdo!',
            ],
            [
                'language_id' => 10,
                'title' => 'तपाईंको राइडसेफ ड्राइभर आइपुग्छ',
                'description' => 'भित्र पस्नु अघि चालकले उनीहरूको सेल्फीसँग मेल खाएको जाँच गर्नुहोस्। आवश्यक परेमा तपाईंले RideSafe एप मार्फत सन्देश पठाउन र कल गर्न सक्नुहुन्छ!',
            ],
            [
                'language_id' => 11,
                'title' => 'Dereva wako wa RideSafe Anawasili',
                'description' => 'Angalia kiendeshi kinalingana na selfie yake kabla ya kuingia. Unaweza kutuma ujumbe na kumpigia simu kupitia programu ya RideSafe ikihitajika!',
            ],
            [
                'language_id' => 12,
                'title' => 'Ваш водитель RideSafe прибывает',
                'description' => 'Прежде чем сесть в машину, проверьте, соответствует ли водитель своему селфи. При необходимости вы можете отправить ему сообщение или позвонить через приложение RideSafe!',
            ],
            [
                'language_id' => 13,
                'title' => '您的乘車安全司機到達',
                'description' => '上車前檢查司機是否與他們的自拍照相符。',
            ],
            [
                'language_id' => 1,
                'parent_id' => 0,
                'step' => 1,
                'title' => 'Enjoy Your Journey',
                'description' => 'Busy tonight drive? Lovely weather we’re having!',
                'type' => 'USER',
                'image' => 'https://dev.meemcolart.com/storage/website/PqLnDDYcN9vILC1EikeaPWqJMoHu6QTBq7I3QlnN.png'
            ],
            [
                'language_id' => 2,
                'title' => 'Bucură-te de călătoria ta',
                'description' => 'Ocupat cu mașina în seara asta? Vreme minunată avem!',
            ],
            [
                'language_id' => 3,
                'title' => 'استمتع برحلتك',
                'description' => 'هل أنت مشغول بالقيادة الليلة؟ الطقس جميل!',
            ],
            [
                'language_id' => 4,
                'title' => 'Din RideSafe-förare anländer',
                'description' => 'Upptagen med bilresan ikväll? Härligt väder vi har!',
            ],
            [
                'language_id' => 5,
                'title' => 'Disfruta tu viaje',
                'description' => '¿Esta noche vas a conducir con mucho tráfico? ¡Hace un tiempo precioso!',
            ],
            [
                'language_id' => 6,
                'title' => 'Profitez de votre voyage',
                'description' => 'Vous êtes occupés ce soir ? Nous avons un temps magnifique !',
            ],
            [
                'language_id' => 7,
                'title' => 'Ciesz się podróżą',
                'description' => 'Zajęci dziś wieczorem jazdą? Mamy piękną pogodę!',
            ],
            [
                'language_id' => 8,
                'title' => 'Nauti matkastasi',
                'description' => 'Oletko kiireinen tänä iltana? Ihana sää meillä!',
            ],
            [
                'language_id' => 9,
                'title' => 'Ku raaxayso safarkaaga',
                'description' => 'Mashquulsan tahay caawa baabuur? Cimilo qurxoon ayaanu ku jirnaa!',
            ],
            [
                'language_id' => 10,
                'title' => 'तपाईंको यात्राको आनन्द लिनुहोस्',
                'description' => 'व्यस्त आज राती ड्राइभ? हामीसँग राम्रो मौसम छ!',
            ],
            [
                'language_id' => 11,
                'title' => 'Furahia Safari Yako',
                'description' => 'Je, una shughuli nyingi za kuendesha gari usiku wa leo? Hali ya hewa nzuri tunayo!',
            ],
            [
                'language_id' => 12,
                'title' => 'Приятного путешествия',
                'description' => 'Заняты сегодня вечером? У нас прекрасная погода!',
            ],
            [
                'language_id' => 13,
                'title' => '享受你的旅程',
                'description' => '今晚開車忙嗎？我們的天氣真好！',
            ],
            [
                'language_id' => 1,
                'parent_id' => 0,
                'step' => 1,
                'title' => 'You’ve Arrived',
                'description' => 'Arrive safely at your destination.',
                'type' => 'USER',
                'image' => 'https://dev.meemcolart.com/storage/website/lV7XznXgahKzOt602wc58veHgF9me6Tum4jqbJIq.png'
            ],
            [
                'language_id' => 2,
                'title' => 'Ai sosit',
                'description' => 'Ajunge în siguranță la destinație.',
            ],
            [
                'language_id' => 3,
                'title' => 'لقد وصلت',
                'description' => 'الوصول بسلامة إلى وجهتك.',
            ],
            [
                'language_id' => 4,
                'title' => 'Du har anlänt',
                'description' => 'Kom säkert fram till din destination.',
            ],
            [
                'language_id' => 5,
                'title' => 'Has llegado',
                'description' => 'Llega sano y salvo a tu destino.',
            ],
            [
                'language_id' => 6,
                'title' => 'Vous êtes arrivés',
                'description' => 'Arrivez à destination en toute sécurité.',
            ],
            [
                'language_id' => 7,
                'title' => 'Dotarłeś',
                'description' => 'Dotrzyj bezpiecznie do celu.',
            ],
            [
                'language_id' => 8,
                'title' => 'Olet saapunut',
                'description' => 'Saavu turvallisesti määränpäähäsi.',
            ],
            [
                'language_id' => 9,
                'title' => 'Waad timid',
                'description' => 'Si nabad ah ku tag meeshaad u socoto.',
            ],
            [
                'language_id' => 10,
                'title' => 'तपाईं आइपुग्नु भएको छ',
                'description' => 'आफ्नो गन्तव्यमा सुरक्षित आइपुग्नुहोस्।',
            ],
            [
                'language_id' => 11,
                'title' => 'Umefika',
                'description' => 'Fika salama unakoenda.',
            ],
            [
                'language_id' => 12,
                'title' => 'Вы прибыли',
                'description' => 'Благополучно доберитесь до места назначения.',
            ],
            [
                'language_id' => 13,
                'title' => '您已抵達',
                'description' => '安全抵達目的地。',
            ],
            [
                'language_id' => 1,
                'parent_id' => 0,
                'step' => 1,
                'title' => 'Smooth Ride?',
                'description' => 'Let your driver know by leaving them a review!',
                'type' => 'USER',
                'image' => 'https://dev.meemcolart.com/storage/website/G2Nee2k5No7bbmazRh95V7IAOJbR881jlXbJIdeI.jpeg'
            ],
            [
                'language_id' => 2,
                'title' => 'Smooth Ride?',
                'description' => 'Anunțați șoferul dvs. lăsându-i o recenzie!',
            ],
            [
                'language_id' => 3,
                'title' => 'رحلة سلسة؟',
                'description' => 'أخبر سائقك بذلك عن طريق ترك تعليق له!',
            ],
            [
                'language_id' => 4,
                'title' => 'Kom säkert fram till din destination.',
                'description' => 'Låt din förare veta genom att lämna en recension!',
            ],
            [
                'language_id' => 5,
                'title' => '¿Viaje suave?',
                'description' => '¡Hazle saber a tu conductor dejándole una reseña!',
            ],
            [
                'language_id' => 6,
                'title' => 'Une conduite en douceur ?',
                'description' => 'Faites-le savoir à votre chauffeur en lui laissant un avis !',
            ],
            [
                'language_id' => 7,
                'title' => 'Gładka jazda?',
                'description' => 'Daj znać swojemu kierowcy i zostaw mu recenzję!',
            ],
            [
                'language_id' => 8,
                'title' => 'Smooth Ride?',
                'description' => 'Kerro kuljettajallesi jättämällä heille arvostelu!',
            ],
            [
                'language_id' => 9,
                'title' => 'Raadraac fudud?',
                'description' => 'U sheeg darawalkaaga adiga oo uga tagaya dib u eegis!',
            ],
            [
                'language_id' => 10,
                'title' => 'सहज सवारी?',
                'description' => 'आफ्नो चालकलाई एक समीक्षा छोडेर थाहा दिनुहोस्!',
            ],
            [
                'language_id' => 11,
                'title' => 'Usafiri Mlaini?',
                'description' => 'Mjulishe dereva wako kwa kuwaachia ukaguzi!',
            ],
            [
                'language_id' => 12,
                'title' => 'Плавный ход?',
                'description' => 'Сообщите об этом своему водителю, оставив ему отзыв!',
            ],
            [
                'language_id' => 13,
                'title' => '平穩行駛？',
                'description' => '給您的司機留下評論，讓他們知道！',
            ],
        ];
    }
}
