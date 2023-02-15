!function(){"use strict";var e,t={301:function(){var e=window.wp.blocks;function t(){return t=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var a in n)Object.prototype.hasOwnProperty.call(n,a)&&(e[a]=n[a])}return e},t.apply(this,arguments)}var n=window.wp.element,a=(window.wp.i18n,window.wp.blockEditor),l=window.wp.components,o=e=>{let{dataId:t,text:o,title:c,iconImage:r,onChangeIconColumnProperty:i,onRemoveIconColumn:s}=e;const m=["image"];return(0,n.createElement)("div",{className:"col-12 col-sm-6 col-lg-4 mb-4 pe-lg-4 mb-4"},(0,n.createElement)("div",{className:"icons-columns__card"},!!r&&(0,n.createElement)("div",{className:"icons-columns__card-left"},(0,n.createElement)("img",{className:"icons-columns__card-left--img",src:r.url})),(0,n.createElement)("div",{className:"icons-columns__card-right"},(0,n.createElement)(a.RichText,{tagName:"h3",className:"IconColumn_title",placeholder:"Add title",value:c,onChange:e=>i("title",e,t)}),(0,n.createElement)(a.RichText,{tagName:"p",className:"IconColumn_text",placeholder:"Add text",value:o,onChange:e=>i("text",e,t)}))),(0,n.createElement)("div",{className:"d-flex align-items-center mt-4"},(0,n.createElement)(l.Button,{onClick:()=>s(t),className:"removeBtn components-button me-2",variant:"secondary",isDestructive:!0,icon:"no-alt"},"Remove column"),r?(0,n.createElement)(n.Fragment,null,(0,n.createElement)(a.MediaUpload,{onSelect:e=>i("iconImage",e,t),allowedTypes:m,render:e=>{let{open:t}=e;return(0,n.createElement)(n.Fragment,null,(0,n.createElement)(l.Button,{variant:"secondary",onClick:t},"Change icon"))}})):(0,n.createElement)(a.MediaUpload,{onSelect:e=>i("iconImage",e,t),allowedTypes:m,render:e=>{let{open:t}=e;return(0,n.createElement)(n.Fragment,null,(0,n.createElement)(l.Button,{variant:"secondary",onClick:t},"Upload icon"))}})))},c=JSON.parse('{"u2":"create-block/icons-columns"}');(0,e.registerBlockType)(c.u2,{edit:function(e){const c=(0,a.useBlockProps)(),{setAttributes:r,attributes:{title:i,iconsColumns:s,backgroundColor:m}}=e,d=(e,t,n)=>{if(!s||0===s.length)return;const a=s.map((a=>a.dataId===n?{...a,..."iconImage"===e&&{iconImage:t},..."text"===e&&{text:t},..."title"===e&&{title:t}}:a));r({iconsColumns:a})},u=()=>{let e=0,t=[];s&&0!==s.length?(e=s.length-1+1,t=[...s,{dataId:e,text:"",clientName:"",rate:5}]):t=[{dataId:e,text:"",clientName:"",rate:5}],t.sort(((e,t)=>e.dataId-t.dataId)),r({iconsColumns:t})},v=e=>{const t=s.filter((t=>t.dataId!==e)).map(((e,t)=>({...e,dataId:t})));t.sort(((e,t)=>e.dataId-t.dataId)),r({iconsColumns:t})};return(0,n.createElement)("section",t({},c,{className:`${m} wp-block-create-block-icons-columns`}),(0,n.createElement)(a.InspectorControls,{key:"setting"},(0,n.createElement)("div",{id:"icons-columns-control"},(0,n.createElement)("fieldset",{class:"p-3"},(0,n.createElement)("legend",{className:"icons-columns-control__label"},"Background color"),(0,n.createElement)(l.SelectControl,{value:m,onChange:e=>{(e=>{r({backgroundColor:e})})(e)},__nextHasNoMarginBottom:!0},(0,n.createElement)("option",{value:"white-bg"},"White"),(0,n.createElement)("option",{value:"lgrey-bg"},"Grey"))))),(0,n.createElement)("div",{className:"container"},(0,n.createElement)("div",{className:"icons-columns"},(0,n.createElement)("div",{className:"row"},(0,n.createElement)("div",{className:"col-12 col-xl-3 mb-5 mb-xl-0"},(0,n.createElement)("div",{className:"icons-columns__content-box"},(0,n.createElement)(a.RichText,{tagName:"h2",className:"icons-columns__header",placeholder:"Add title",value:i,onChange:e=>r({title:e})}))),(0,n.createElement)("div",{className:"col-12 col-xl-8 offset-xl-1"},(0,n.createElement)("div",{className:"icons-columns__row row"},s&&0!==s.length?(0,n.createElement)(n.Fragment,null,0!==s.length&&s.map((e=>{var t;return(0,n.createElement)(n.Fragment,null,(0,n.createElement)(o,{key:e.dataId,dataId:e.dataId,text:e.text,iconImage:null!==(t=e.iconImage)&&void 0!==t?t:null,title:e.title,onChangeIconColumnProperty:d,onRemoveIconColumn:v}),e.dataId===s.length-1&&(0,n.createElement)("div",{className:"col-4 py-5"},(0,n.createElement)(l.Button,{variant:"secondary",onClick:u},"Add another column")))}))):(0,n.createElement)("div",{className:"col-4 py-5"},(0,n.createElement)(l.Button,{variant:"secondary",onClick:u},"Add column"))))))))}})}},n={};function a(e){var l=n[e];if(void 0!==l)return l.exports;var o=n[e]={exports:{}};return t[e](o,o.exports,a),o.exports}a.m=t,e=[],a.O=function(t,n,l,o){if(!n){var c=1/0;for(m=0;m<e.length;m++){n=e[m][0],l=e[m][1],o=e[m][2];for(var r=!0,i=0;i<n.length;i++)(!1&o||c>=o)&&Object.keys(a.O).every((function(e){return a.O[e](n[i])}))?n.splice(i--,1):(r=!1,o<c&&(c=o));if(r){e.splice(m--,1);var s=l();void 0!==s&&(t=s)}}return t}o=o||0;for(var m=e.length;m>0&&e[m-1][2]>o;m--)e[m]=e[m-1];e[m]=[n,l,o]},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){var e={826:0,431:0};a.O.j=function(t){return 0===e[t]};var t=function(t,n){var l,o,c=n[0],r=n[1],i=n[2],s=0;if(c.some((function(t){return 0!==e[t]}))){for(l in r)a.o(r,l)&&(a.m[l]=r[l]);if(i)var m=i(a)}for(t&&t(n);s<c.length;s++)o=c[s],a.o(e,o)&&e[o]&&e[o][0](),e[o]=0;return a.O(m)},n=self.webpackChunkicons_columns=self.webpackChunkicons_columns||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))}();var l=a.O(void 0,[431],(function(){return a(301)}));l=a.O(l)}();