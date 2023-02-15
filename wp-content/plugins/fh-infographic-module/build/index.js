(()=>{"use strict";var e,a={165:()=>{const e=window.wp.blocks;function a(){return a=Object.assign?Object.assign.bind():function(e){for(var a=1;a<arguments.length;a++){var t=arguments[a];for(var l in t)Object.prototype.hasOwnProperty.call(t,l)&&(e[l]=t[l])}return e},a.apply(this,arguments)}const t=window.wp.element,l=window.wp.i18n,n=window.wp.blockEditor,r=window.wp.components,o=JSON.parse('{"u2":"create-block/fh-infographic-module"}');(0,e.registerBlockType)(o.u2,{edit:function(e){const{setAttributes:o,attributes:{title:c,content:i,mainImage:m,backgroundImage:s}}=e,u=(0,n.useBlockProps)();return(0,t.createElement)("section",a({},u,{className:"infographic-module"}),(0,t.createElement)(n.InspectorControls,{key:"setting"},(0,t.createElement)("div",{id:"infographic-module-control"},(0,t.createElement)("fieldset",{className:"p-3"},(0,t.createElement)("legend",{className:"infographic-module-control__label"},"Main infographic image"),(0,t.createElement)(n.MediaUpload,{onSelect:function(a){return e.setAttributes({mainImage:a.url})},allowedTypes:"image",className:"fc-media-ID",value:m,render:e=>{let{open:a}=e;return(0,t.createElement)(r.Button,{className:m?"image-button":"button button-large mb-3",onClick:a},m?(0,t.createElement)("img",{className:"fc-media-url",src:m,alt:(0,l.__)("Upload Image")}):(0,l.__)("Upload Image"))}}),m&&(0,t.createElement)(r.Button,{onClick:()=>e.setAttributes({mainImage:null})},"remove")),(0,t.createElement)("fieldset",{className:"p-3"},(0,t.createElement)("legend",{className:"infographic-module-control__label"},"Background image"),(0,t.createElement)(n.MediaUpload,{onSelect:function(a){return e.setAttributes({backgroundImage:a.url})},allowedTypes:"image",className:"fc-media-ID",value:s,render:e=>{let{open:a}=e;return(0,t.createElement)(r.Button,{className:s?"image-button":"button button-large mb-3",onClick:a},s?(0,t.createElement)("img",{className:"fc-media-url",src:s,alt:(0,l.__)("Upload Image")}):(0,l.__)("Upload Image"))}}),s&&(0,t.createElement)(r.Button,{onClick:()=>e.setAttributes({backgroundImage:null})},"remove")))),(0,t.createElement)("figure",{className:"infographic-module-background",style:{backgroundImage:"url("+s+")"}}),(0,t.createElement)("div",{className:"container"},(0,t.createElement)("div",{className:"row"},(0,t.createElement)("div",{className:"col-12 col-xl-4 infographic-module__content"},(0,t.createElement)(n.RichText,{tagName:"h2",value:c,allowedFormats:["core/bold","core/italic"],onChange:e=>o({title:e}),placeholder:(0,l.__)("Insert block title here...")}),(0,t.createElement)(n.RichText,{tagName:"p",className:"content ps-0 medium",value:i,allowedFormats:["core/bold","core/italic"],onChange:e=>o({content:e}),placeholder:(0,l.__)("Insert block content here...")})),(0,t.createElement)("div",{className:"col-xl-8 col-12 pe-lg-4"},m&&(0,t.createElement)("figure",{className:"infographic-module__main-image-wrapper"},(0,t.createElement)("img",{className:"infographic-module__image",src:m}))))))},save:function(e){const l=n.useBlockProps.save(),{attributes:{title:r,content:o,backgroundImage:c,mainImage:i}}=e;return(0,t.createElement)("section",a({},l,{className:"infographic-module parallax-window","data-parallax":"scroll","data-image-src":c}),(0,t.createElement)("figure",{className:"infographic-module-background",style:{backgroundImage:"url("+c+")"}}),(0,t.createElement)("div",{class:"container"},(0,t.createElement)("div",{class:"row"},(0,t.createElement)("div",{class:"col-12 col-xl-4 infographic-module__content"},r&&(0,t.createElement)(n.RichText.Content,{className:"mt-0",tagName:"h2",value:r}),r&&(0,t.createElement)(n.RichText.Content,{className:"medium",tagName:"p",value:o})),(0,t.createElement)("div",{className:"col-xl-8 col-12 pe-lg-4"},c&&(0,t.createElement)("figure",{className:"infographic-module__main-image-wrapper"},(0,t.createElement)("img",{className:"infographic-module__image",src:i,alt:"photo"}))))))}})}},t={};function l(e){var n=t[e];if(void 0!==n)return n.exports;var r=t[e]={exports:{}};return a[e](r,r.exports,l),r.exports}l.m=a,e=[],l.O=(a,t,n,r)=>{if(!t){var o=1/0;for(s=0;s<e.length;s++){for(var[t,n,r]=e[s],c=!0,i=0;i<t.length;i++)(!1&r||o>=r)&&Object.keys(l.O).every((e=>l.O[e](t[i])))?t.splice(i--,1):(c=!1,r<o&&(o=r));if(c){e.splice(s--,1);var m=n();void 0!==m&&(a=m)}}return a}r=r||0;for(var s=e.length;s>0&&e[s-1][2]>r;s--)e[s]=e[s-1];e[s]=[t,n,r]},l.o=(e,a)=>Object.prototype.hasOwnProperty.call(e,a),(()=>{var e={826:0,431:0};l.O.j=a=>0===e[a];var a=(a,t)=>{var n,r,[o,c,i]=t,m=0;if(o.some((a=>0!==e[a]))){for(n in c)l.o(c,n)&&(l.m[n]=c[n]);if(i)var s=i(l)}for(a&&a(t);m<o.length;m++)r=o[m],l.o(e,r)&&e[r]&&e[r][0](),e[r]=0;return l.O(s)},t=globalThis.webpackChunkfh_infographic_module=globalThis.webpackChunkfh_infographic_module||[];t.forEach(a.bind(null,0)),t.push=a.bind(null,t.push.bind(t))})();var n=l.O(void 0,[431],(()=>l(165)));n=l.O(n)})();