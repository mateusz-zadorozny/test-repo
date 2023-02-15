!function(){"use strict";var e,t={449:function(){var e=window.wp.blocks,t=window.wp.element,n=window.wp.i18n,a=window.wp.blockEditor,o=window.wp.components,c=e=>{let{dataId:n,title:c,content:r,onChangeItemTitle:l,onChangeItemContent:i,onRemoveItem:d}=e;return(0,t.createElement)("div",{className:"accordion__item open-accordion-item","data-id":`contactBlock-${n}`},(0,t.createElement)(a.RichText,{tagName:"div",placeholder:"Add item title",className:"accordion__item-main",value:c,onChange:e=>l(e,n)}),(0,t.createElement)(a.RichText,{tagName:"p",className:"accordion__item-content mb-0",placeholder:"Add block content",value:r,onChange:e=>i(e,n)}),(0,t.createElement)(o.Button,{onClick:()=>d(n),className:"removeBtn components-button mt-2 mb-2 me-2",variant:"secondary",isDestructive:!0,icon:"no-alt"},"Remove Item"))},r=JSON.parse('{"u2":"create-block/accordion-module"}');(0,e.registerBlockType)(r.u2,{edit:function(e){const r=(0,a.useBlockProps)(),{setAttributes:l,attributes:{title:i,content:d,items:m}}=e,s=()=>{let e=0,t=[];m&&0!==m.length?(e=m.length-1+1,t=[...m,{dataId:e,title:"",content:""}]):t=[{dataId:e,title:"",content:""}],t.sort(((e,t)=>e.dataId-t.dataId)),l({items:t})},u=(e,t)=>{const n=m.map((n=>n.dataId===t?{...n,title:e}:n));l({items:n})},v=(e,t)=>{const n=m.map((n=>n.dataId===t?{...n,content:e}:n));l({items:n})},h=e=>{const t=m.filter((t=>t.dataId!==e)).map(((e,t)=>({...e,dataId:t})));t.sort(((e,t)=>e.dataId-t.dataId)),l({items:t})};return(0,t.createElement)("section",r,(0,t.createElement)("div",{className:"container"},(0,t.createElement)("div",{className:"row"},(0,t.createElement)("div",{className:"col-12 col-xl-3 mb-5 mb-xl-0"},(0,t.createElement)("div",null,(0,t.createElement)(a.RichText,{tagName:"h2",className:"accordion-module__header",value:i,allowedFormats:["core/bold","core/italic"],onChange:e=>l({title:e}),placeholder:(0,n.__)("Insert block title here...")}),(0,t.createElement)(a.RichText,{tagName:"p",className:"accordion-module__text",value:d,allowedFormats:["core/bold","core/italic"],onChange:e=>l({content:e}),placeholder:(0,n.__)("Insert block content here...")}))),(0,t.createElement)("div",{className:"col-12 col-xl-8 offset-xl-1"},m&&0!==m.length?(0,t.createElement)("div",{className:"accordion"},0!==m.length&&m.map((e=>(0,t.createElement)(t.Fragment,null,(0,t.createElement)(c,{key:e.dataId,dataId:e.dataId,title:e.title,content:e.content,onChangeItemTitle:u,onChangeItemContent:v,onRemoveItem:h}),e.dataId===m.length-1&&(0,t.createElement)(o.Button,{variant:"secondary",onClick:s},"Add another item"))))):(0,t.createElement)(o.Button,{variant:"secondary",onClick:s},"Add item")))))}})}},n={};function a(e){var o=n[e];if(void 0!==o)return o.exports;var c=n[e]={exports:{}};return t[e](c,c.exports,a),c.exports}a.m=t,e=[],a.O=function(t,n,o,c){if(!n){var r=1/0;for(m=0;m<e.length;m++){n=e[m][0],o=e[m][1],c=e[m][2];for(var l=!0,i=0;i<n.length;i++)(!1&c||r>=c)&&Object.keys(a.O).every((function(e){return a.O[e](n[i])}))?n.splice(i--,1):(l=!1,c<r&&(r=c));if(l){e.splice(m--,1);var d=o();void 0!==d&&(t=d)}}return t}c=c||0;for(var m=e.length;m>0&&e[m-1][2]>c;m--)e[m]=e[m-1];e[m]=[n,o,c]},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){var e={826:0,431:0};a.O.j=function(t){return 0===e[t]};var t=function(t,n){var o,c,r=n[0],l=n[1],i=n[2],d=0;if(r.some((function(t){return 0!==e[t]}))){for(o in l)a.o(l,o)&&(a.m[o]=l[o]);if(i)var m=i(a)}for(t&&t(n);d<r.length;d++)c=r[d],a.o(e,c)&&e[c]&&e[c][0](),e[c]=0;return a.O(m)},n=self.webpackChunkaccordion_module=self.webpackChunkaccordion_module||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))}();var o=a.O(void 0,[431],(function(){return a(449)}));o=a.O(o)}();