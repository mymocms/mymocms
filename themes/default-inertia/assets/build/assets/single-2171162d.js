import{j as e,a as i,d as c}from"./app-13cc16b3.js";import{u as o,_ as r}from"./functions-503419f4.js";import f from"./main-c1f7e2e7.js";import u from"./comment-form-3e0d0928.js";import"./header-16ec2555.js";import"./primary-menu-139672a4.js";import"./menu_item-a66a5f3c.js";import"./footer-7b42e382.js";import"./comments-ecfef8a9.js";import"./fetch-b062eefd.js";function j({post:l,canonical:s,comments:N}){var m,d,h;const n=(m=l==null?void 0:l.taxonomies)==null?void 0:m.filter(a=>a.taxonomy==="categories"),t=((d=l.taxonomies)==null?void 0:d.filter(a=>a.taxonomy==="tags"))||null;return e(f,{children:e("section",{className:"pb-80",children:e("div",{className:"container",children:i("div",{className:"row",children:[e("div",{className:"col-md-12",children:e("ul",{className:"breadcrumbs bg-light mb-4",children:e("li",{className:"breadcrumbs__item",children:i(c,{href:o("/"),className:"breadcrumbs__url",children:[e("i",{className:"fa fa-home"})," ",r("Home")]})})})}),i("div",{className:"col-md-8",children:[i("div",{className:"wrap__article-detail",children:[i("div",{className:"wrap__article-detail-title",children:[e("h1",{children:l.title}),e("h3",{children:l.description})]}),e("hr",{}),e("div",{className:"wrap__article-detail-info",children:i("ul",{className:"list-inline",children:[i("li",{className:"list-inline-item",children:[e("span",{children:r("by")}),i("a",{href:"#",children:[(h=l.author)==null?void 0:h.name,","]})]}),e("li",{className:"list-inline-item",children:e("span",{className:"text-dark text-capitalize ml-1",children:l.created_at})}),i("li",{className:"list-inline-item",children:[e("span",{className:"text-dark text-capitalize ml-1 mr-1",children:r("in")}),n==null?void 0:n.map(a=>e(c,{href:a.url,children:a.name},a.id))]})]})}),e("div",{className:"wrap__article-detail-image mt-4",children:e("figure",{children:e("img",{src:l.thumbnail,alt:l.title,className:"img-fluid"})})}),i("div",{className:"wrap__article-detail-content",children:[i("div",{className:"total-views",children:[i("div",{className:"total-views-read",children:[l.views.toString(),e("span",{children:r("views")})]}),i("ul",{className:"list-inline",children:[i("span",{className:"share",children:[r("share on"),":"]}),e("li",{className:"list-inline-item",children:i("a",{className:"btn btn-social-o facebook",href:`https://www.facebook.com/sharer/sharer.php?u=${s}&t=${l.title}`,children:[e("i",{className:"fa fa-facebook-f"}),e("span",{children:"facebook"})]})}),e("li",{className:"list-inline-item",children:i("a",{className:"btn btn-social-o twitter",href:`https://twitter.com/intent/tweet?url=${s}&text=${l.title}`,children:[e("i",{className:"fa fa-twitter"}),e("span",{children:"twitter"})]})}),e("li",{className:"list-inline-item",children:i("a",{className:"btn btn-social-o telegram",href:`https://t.me/share/url?url=${s}&text=${l.title}`,children:[e("i",{className:"fa fa-telegram"}),e("span",{children:"telegram"})]})}),e("li",{className:"list-inline-item",children:i("a",{className:"btn btn-linkedin-o linkedin",href:`https://www.linkedin.com/shareArticle?url=${s}&mini=true`,children:[e("i",{className:"fa fa-linkedin"}),e("span",{children:"linkedin"})]})})]})]}),e("div",{dangerouslySetInnerHTML:{__html:(l==null?void 0:l.content)||""}})]})]}),e("div",{className:"blog-tags",children:i("ul",{className:"list-inline",children:[e("li",{className:"list-inline-item",children:e("i",{className:"fa fa-tags"})}),t&&t.map(a=>e("li",{className:"list-inline-item",children:e(c,{href:a.url,children:a.name})},a.id))]})}),e(u,{post:l,comments:N}),e("div",{className:"clearfix"})]}),e("div",{className:"col-md-4",children:e("div",{className:"sticky-top"})})]})})})})}export{j as default};