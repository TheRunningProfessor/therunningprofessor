(window.blocksyJsonP=window.blocksyJsonP||[]).push([[1],{134:function(e,t,c){"use strict";c.r(t),c.d(t,"mount",(function(){return i}));var n=c(0),o=c(2),a=c(29),l=c.n(a);var s=({initialStatus:e,url:t,pluginUrl:c,pluginLink:a})=>{const[s,i]=Object(n.useState)("installed"),[r,u]=Object(n.useState)(!1),b=Object(n.useRef)(null);return Object(n.useEffect)(()=>{i(e)},[]),Object(n.createElement)("div",{className:"ct-blocksy-plugin-inner",ref:b},Object(n.createElement)("button",{onClick:()=>{b.current.closest(".notice-blocksy-plugin").parentNode.removeChild(b.current.closest(".notice-blocksy-plugin")),l.a.ajax(ajaxurl,{type:"POST",data:{action:"blocksy_dismissed_notice_handler"}})},type:"button",className:"notice-dismiss"},Object(n.createElement)("span",{className:"screen-reader-text"},Object(o.__)("Dismiss this notice.","blocksy"))),Object(n.createElement)("span",{className:"ct-notification-icon"},Object(n.createElement)("svg",{width:"50",height:"50",viewBox:"0 0 50 50",xmlns:"http://www.w3.org/2000/svg"},Object(n.createElement)("path",{d:"M25 0c13.807 0 25 11.193 25 25S38.807 50 25 50 0 38.807 0 25 11.193 0 25 0zm4.735 25.637a.237.237 0 00-.312 0L19.28 34.83c-.069.063-.02.171.078.171h9.492c.116 0 .229-.042.312-.117l4.45-4.035a1.122 1.122 0 000-1.697zm0-10a.237.237 0 00-.312 0L18.13 25.873a.382.382 0 00-.129.282v7.613c0 .09.119.134.188.071l14.636-13.333c.517-.468.518-1.589 0-2.057zM27.674 15H18.22c-.122 0-.221.09-.221.2v8.568c0 .09.119.134.188.071l9.564-8.668c.07-.063.02-.171-.078-.171z",fill:"#23282D","fill-rule":"evenodd"}))),Object(n.createElement)("div",{className:"ct-notification-content"},Object(n.createElement)("h2",null,Object(o.__)("Thanks for installing Blocksy, you rock!","blocksy")),Object(n.createElement)("p",{dangerouslySetInnerHTML:{__html:Object(o.__)("We strongly recommend you to activate the <b>Blocksy Companion</b> plugin.<br>This way you will have access to custom extensions, demo templates and many other awesome features.","blocksy")}}),Object(n.createElement)("div",{className:"notice-actions"},null,Object(n.createElement)("button",{className:"button button-primary",disabled:r||"active"===s,onClick:()=>{u(!0),setTimeout(()=>{}),l.a.ajax(ajaxurl,{type:"POST",data:{action:"blocksy_notice_button_click"}}).then(({success:e,data:t})=>{e&&(i(t.status),"active"===t.status&&location.assign(c)),u(!1)})}},r?Object(o.__)("Installing & activating...","blocksy"):"uninstalled"===s?Object(o.__)("Install Blocksy Companion","blocksy"):"installed"===s?Object(o.__)("Activate Blocksy Companion","blocksy"):Object(o.__)("Blocksy Companion active!","blocksy"),r&&Object(n.createElement)("i",{className:"dashicons dashicons-update"})),Object(n.createElement)("a",{className:"ct-why-button button",href:"https://creativethemes.com/blocksy/companion/"},Object(o.__)("Why you need Blocksy Companion?","blocksy")))))};const i=e=>{e.querySelector(".notice-blocksy-plugin-root")&&Object(n.render)(Object(n.createElement)(s,{initialStatus:e.querySelector(".notice-blocksy-plugin-root").dataset.pluginStatus,url:e.querySelector(".notice-blocksy-plugin-root").dataset.url,pluginUrl:e.querySelector(".notice-blocksy-plugin-root").dataset.pluginUrl,pluginLink:e.querySelector(".notice-blocksy-plugin-root").dataset.link}),e.querySelector(".notice-blocksy-plugin-root")),[...document.querySelectorAll("[data-dismiss]")].map(e=>{e.addEventListener("click",t=>{t.preventDefault(),e.closest(".notice-blocksy-woo-deprecation").remove(),l.a.ajax(ajaxurl,{type:"POST",data:{action:"blocksy_dismissed_notice_woo_deprecation"}})})})}}}]);