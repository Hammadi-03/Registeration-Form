(function(){
  const translations = {
    id: {
      title: 'Pendaftaran Siswa',
      subtitle: 'Daftar untuk mengakses layanan',
      label_name:'Nama Lengkap',
      label_password:'Password',
      ph_password:'Buat password minimal 8 karakter',
      label_confirm:'Konfirmasi Password',
      ph_confirm:'Ulangi password',
      ph_name:'Masukkan nama lengkap',
      label_email:'Email',
      ph_email:'contoh@email.com',
      label_kelas:'Kelas',
      opt_select:'-- Pilih Kelas --',
      label_jk:'Jenis Kelamin',
      jk_l:'Laki-laki',
      jk_p:'Perempuan',
      btn_submit:'Daftar Sekarang'
    },
    en: {
      title: 'Student Registration',
      subtitle: 'Sign up to access services',
      label_name:'Full Name',
      label_password:'Password',
      ph_password:'Create a password (min 8 chars)',
      label_confirm:'Confirm Password',
      ph_confirm:'Repeat password',
      ph_name:'Enter full name',
      label_email:'Email',
      ph_email:'name@example.com',
      label_kelas:'Class',
      opt_select:'-- Select Class --',
      label_jk:'Gender',
      jk_l:'Male',
      jk_p:'Female',
      btn_submit:'Sign Up'
    }
  };

  function detectAutoLang(){
    // Use navigator language and timezone as heuristics
    const nav = (navigator.languages && navigator.languages[0]) || navigator.language || '';
    const tz = (Intl.DateTimeFormat && Intl.DateTimeFormat().resolvedOptions && Intl.DateTimeFormat().resolvedOptions().timeZone) || '';
    const navLang = String(nav).toLowerCase();
    const tzStr = String(tz);

    // If browser language is Indonesian -> id
    if(navLang.startsWith('id') || navLang.startsWith('in')) return 'id';

    // Timezones for Indonesia
    if(/jakarta|makassar|jayapura|palembang|asia\/jakarta|asia\/makassar|asia\/jayapura/i.test(tzStr)) return 'id';

    // Common Middle East languages -> prefer English per your request
    if(/^ar|^fa|^ps|^ur|^he|^ku/.test(navLang)) return 'en';

    // Middle East timezones -> prefer English
    if(/dubai|kuwait|qatar|riyadh|bahrain|amman|beirut|jerusalem|baghdad|tehran|istanbul/i.test(tzStr)) return 'en';

    // If browser prefers English
    if(navLang.startsWith('en')) return 'en';

    // Fallback to Indonesian (site is local); you can change fallback to 'en' if preferred
    return 'id';
  }

  const setLang = (lang) => {
    const t = translations[lang] || translations['id'];
    document.querySelectorAll('[data-i18n]').forEach(el=>{
      const key = el.getAttribute('data-i18n');
      if(t[key]) el.textContent = t[key];
    });
    document.querySelectorAll('[data-i18n-placeholder]').forEach(el=>{
      const key = el.getAttribute('data-i18n-placeholder');
      if(t[key]) el.placeholder = t[key];
    });
    // update select/option text if using data-i18n on options
    document.querySelectorAll('[data-i18n-option]').forEach(el=>{
      const key = el.getAttribute('data-i18n-option');
      if(t[key]) el.textContent = t[key];
    });

    // update radio label translations (they use data-i18n keys jk_l / jk_p)
    document.querySelectorAll('[data-i18n="jk_l"]').forEach(el=> el.textContent = t['jk_l']);
    document.querySelectorAll('[data-i18n="jk_p"]').forEach(el=> el.textContent = t['jk_p']);

    // set hidden lang input
    const hidden = document.getElementById('lang');
    if(hidden) hidden.value = lang;

    // toggle active
    document.querySelectorAll('.lang-btn').forEach(btn=>{
      const l=btn.getAttribute('data-lang');
      const pressed = l === lang;
      btn.classList.toggle('active', pressed);
      btn.setAttribute('aria-pressed', pressed ? 'true' : 'false');
    });

    try{localStorage.setItem('siteLang', lang);}catch(e){}
  };

  document.addEventListener('DOMContentLoaded', ()=>{
    document.querySelectorAll('.lang-btn').forEach(btn=>{
      btn.addEventListener('click', ()=> setLang(btn.getAttribute('data-lang')));
    });
    let start = 'id';
    if(window.initialLang) start = window.initialLang;
    else {
      try { start = localStorage.getItem('siteLang') || detectAutoLang(); } catch(e){ start = detectAutoLang(); }
    }
    setLang(start);
  });
})();