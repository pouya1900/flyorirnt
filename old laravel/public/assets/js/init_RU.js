ct_$('html').ultimateGDPR({
    popup_style: {
        position: 'bottom-panel', // bottom-left, bottom-right, bottom-panel, top-left, top-right, top-panel
        distance: '20px', // distance betwen popup and window border
        box_style: 'classic', // classic, modern
        box_shape: 'rounded', // rounded, squared
        background_color: '#fff584', // color in hex
        text_color: '#542d04', // color in hex
        button_shape: 'rounded', // squared, rounded
        button_color: '#e1e1e1', // color in hex
        button_size: 'normal', // normal, large
        box_skin: 'skin-dark-theme', // skin-default-theme, skin-dark-theme, skin-light-theme
        gear_icon_position: 'bottom-left', // top-left, top-center, top-right, center-left, center-right, bottom-left, bottom-center, bottom-right
        gear_icon_color: '#6a8ee7', //color in hex
    }, popup_options: {
        parent_container: 'body', // append plugin html to this element selector
        always_show: false, // true, false, when true popup is displayed always even when consent is given
        gear_display: false, // true, false when true displays icon with cookie settings
        popup_title: 'Cookies', // title for popup
        popup_text: 'Cookies Чтобы этот сайт работал правильно, мы иногда помещаем на ваше устройство небольшие файлы данных, называемые куки. Большинство крупных сайтов делают это тоже.', // text for popup
        accept_button_text: 'принимать', // string, text for accept button
        reject_button_text: 'Отклонять', // string, text for reject button
        read_button_text: 'Прочитайте больше', // string, text for read more button
        read_more_link: $("input[name='privacy_link']").val(), // string, link to the Read More page
        advenced_button_text: 'Изменить настройки', // string, text for advenced button
        grouped_popup: true, // true, false, when true cookies are grouped
        default_group: 'group_4', // string: name, select group that will be selected by default
        content_before_slider: '<h2>Настройки конфиденциальности</h2><div class="ct-ultimate-gdpr-cookie-modal-desc"><p>Определите, какие файлы cookie вы хотите разрешить.</p><p>Вы можете изменить эти настройки в любое время. Однако это может привести к тому, что некоторые функции больше не доступны. Информацию об удалении файлов cookie см. В справочной службе вашего браузера..</p> <span>Подробнее о куках, которые мы используем.</span></div><h3>С помощью ползунка вы можете включать или отключать различные типы файлов cookie:</h3>', // string: this content will be displayed before cookies slider, html tags alowed
        accepted_text: 'Этот веб-сайт будет:',
        declined_text: "Этот сайт не будет:",
        save_btn: 'Сохранить и закрыть', // string, text for modal close btn
        prevent_cookies_on_document_write: false, // prevent cookies on document write when there is no agreement for cookies
        check_country: false,
        countries_prefixes: ['AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE', 'GB'],
        cookies_expire_time: 30, // set number of days, you can use 0 for session only or 'unlimited'
        cookies_path: '/', // sets custom path use / for global, '/your_path' for custom path or 'current' for current path
        reset_link_selector: '.ct-uGdpr-reset',
        first_party_cookies_whitelist: [],
        third_party_cookies_whitelist: [],
        cookies_groups_design: 'skin-1', // skin-1, skin-2, skin-3
        assets_path: '/assets', // absolute path to directory with assets
        video_blocked: 'Этот контент заблокирован!',
        iframe_blocked: false,
        cookie_popup_close_color: '#fff',
        close_popup_text: '', // Close popup text (If empty, button X(close) will display. If not, it will display the text)
        cookies_groups: {
            group_1: {
                name: 'существенный', // string: name
                enable: true, // true, false, you can disable this group by using false
                icon: 'fas fa-check', // string icon class from font-awesome see -> http://fontawesome.io
                list: ['Помните о настройках вашего файла cookie', 'Разрешить сеанс cookie', 'Собирайте информацию, которую вы вводите в контактную форму, информационный бюллетень и другие формы на всех страницах', 'Следите за тем, что вы вводите в корзину покупок', 'Подтвердите, что вы вошли в свою учетную запись пользователя', 'Запомнить выбранную вами языковую версию'], // array list of options
                blocked_url: [], // array list of url blocked scripts
                local_cookies_name: [], // array, list of local cookies names
            }, group_2: {
                name: 'функциональность', // string: name
                enable: true, // true, false, you can disable this group by using false
                icon: 'fas fa-cog', // string icon class from font-awesome see -> http://fontawesome.io
                list: ['Помните настройки социальных сетей', 'Запомнить выбранный регион и страну',], blocked_url: [], // array list of url blocked scripts
                local_cookies_name: [], // array, list of local cookies names
            }, group_3: {
                name: 'аналитика', // string: name
                enable: true, // true, false, you can disable this group by using false
                icon: 'fas fa-chart-bar', // string icon class from font-awesome see -> http://fontawesome.io
                list: ['Следите за посещенными страницами и', 'Следите за своим местоположением и регионом на основе вашего IP-номера', 'Следите за временем, проведенным на каждой странице', 'Повышение качества данных статистических функций'],
                blocked_url: [], // array list of url blocked scripts
                local_cookies_name: [], // array, list of local cookies names
            }, group_4: {
                name: 'реклама', // string: name
                enable: true, // true, false, you can disable this group by using false
                icon: 'fas fa-exchange-alt', // string icon class from font-awesome see -> http://fontawesome.io
                list: ['Использовать информацию для индивидуальной рекламы с третьими лицами', 'Позвольте подключиться к социальным сайтам', 'Определите устройство, которое вы используете', 'Соберите личную информацию, такую как имя и местоположение'],
                blocked_url: [], // array list of url blocked scripts
                local_cookies_name: [], // array, list of local cookies names
            },
        },
    }, age_popup_style: {
        position: 'none', // bottom-left, bottom-right, bottom-panel, top-left, top-right, top-panel
        distance: '20px', // distance between popup and window border
        box_style: 'classic', // classic, modern
        box_shape: 'rounded', // rounded, squared
        background_color: '#fff584', // color in hex
        text_color: '#542d04', // color in hex
        button_shape: 'rounded', // squared, rounded
        button_color: '#e1e1e1', // color in hex
        box_skin: 'skin-dark-theme', // skin-default-theme, skin-dark-theme, skin-light-theme
    }, age_popup_options: {
        parent_container: 'body', // append plugin html to this element selector
        always_show: false, // true, false, when true popup is displayed always even when consent is given
        popup_title: 'Age verification', // title for popup
        popup_text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.', // text for popup
        age_limit: 13, // age limit to enter
        assets_path: 'assets', // absolute path to directory with assets
        disable_popup: true, // true/false, when true popup will be disabled and hidden on the website
    }, forms: {
        prevent_forms_send: false, // true, false, when enabled forms get checkbox with info that need to be checked for form send
        prevent_forms_text: 'I consent to the storage of my data according to the Privacy Policy', // string: information for checkbox info
        prevent_forms_exclude: [], // array of selectors (classes, id), this forms will be excluded from prevent
    }, configure_mode: {
        on: false,
        parametr: '?configure123456',
        dependencies: ['assets/css/ct-ultimate-gdpr.min.css', 'https://use.fontawesome.com/releases/v5.0.13/css/all.css'],
        debug: false, // bool: true false, debug mode on/off (showing all 3rd party cookies urls, blockes urls names of all local cookies and names of blocked local cookies )
    }
});