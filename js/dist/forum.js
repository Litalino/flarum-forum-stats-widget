(()=>{var t={n:e=>{var o=e&&e.__esModule?()=>e.default:()=>e;return t.d(o,{a:o}),o},d:(e,o)=>{for(var r in o)t.o(o,r)&&!t.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:o[r]})},o:(t,e)=>Object.prototype.hasOwnProperty.call(t,e),r:t=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})}},e={};(()=>{"use strict";t.r(e);const o=flarum.core.compat["extensions/afrux-forum-widgets-core/common/extend/Widgets"];var r=t.n(o);function n(t,e){return n=Object.setPrototypeOf?Object.setPrototypeOf.bind():function(t,e){return t.__proto__=e,t},n(t,e)}const a=flarum.core.compat["common/app"];var i=t.n(a);const s=flarum.core.compat["common/components/Tooltip"];var c=t.n(s);const u=flarum.core.compat["common/helpers/icon"];var l=t.n(u);const p=flarum.core.compat["extensions/afrux-forum-widgets-core/common/components/Widget"];var f=t.n(p);const d=flarum.core.compat["common/utils/extractText"];var g=t.n(d),y=function(t){var e,o;function r(){return t.apply(this,arguments)||this}o=t,(e=r).prototype=Object.create(o.prototype),e.prototype.constructor=e,n(e,o);var a=r.prototype;return a.className=function(){return"Litalino-ForumStatsWidgetWidget"},a.icon=function(){return"fas fa-chart-pie"},a.title=function(){return g()(i().translator.trans("flarum-forum-stats-widget.forum.widget.title"))},a.content=function(){var t=i().forum.attribute("litalino-flarum-forum-stats-widget.stats");return m("div",{className:"Litalino-ForumStatsWidget-grid"},Object.keys(t).map((function(e){return m(c(),{text:t[e].label},m("span",{className:"Litalino-ForumStatsWidget-grid-item"},m("span",{className:"Litalino-ForumStatsWidget-grid-item-icon"},l()(t[e].icon)),m("span",{className:"Litalino-ForumStatsWidget-grid-item-value"},t[e].prettyValue)))})))},r}(f());app.initializers.add("litalino/forum-stats-widget",(function(){!function(t){(new(r())).add({key:"ForumStats",component:y,isDisabled:function(){return!t.forum.attribute("litalino-flarum-forum-stats-widget.stats")},isUnique:!0,placement:"end",position:2}).extend(t,"litalino-forum-stats-widget")}(app)}))})(),module.exports=e})();
//# sourceMappingURL=forum.js.map