var route = document.getElementsByName('routeName')[0].getAttribute('content');
var base = location.protocol+'//'+location.host;
const http = new XMLHttpRequest();
const csrfToken = document.getElementsByName('csrf-token')[0].getAttribute('content');
var page =1;
var page_section = "";

document.addEventListener('DOMContentLoaded', function () {
        var btn_search = document.getElementById('btn_search');
        var form_search = document.getElementById('form_search');
        var posts_lists = document.getElementById('posts_lists');
        var load_more_posts = document.getElementById('load_more_posts');
        if (btn_search) {
            btn_search.addEventListener('click', function (e) {
                e.preventDefault();
                if (form_search.style.display === 'block') {
                    form_search.style.display = 'none';
                } else {
                    form_search.style.display = 'block';
                }
            });
        }
        /*
        if (route == "home") {
            load_posts("home");
        }

        if (load_more_posts){
            load_more_posts.addEventListener('click', function (e){
               e.preventDefault();
               load_posts(page_section);
            });
        }
         */
    }
);

function load_posts(section)
{
    page_section = section;
    var url = base + '/fips/api/load/posts/'+page_section+'?page='+page;
    http.open('GET', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    http.send();
    http.onreadystatechange = function (){
        if (this.readyState == 4 && this.status == 200){
            page = page + 1;
            var data = this.responseText;
            data = JSON.parse(data);

            if (data.data.length == 0){
                load_more_posts.style.display = "none";
            }

            data.data.forEach(function (post, index){
                console.log(post);
                var div = "";
                div += "<div class=\"container-fluid\">";
                    div += "<div class=\"posts\">";
                        div += "<div class=\"card mb-3\" style=\"margin-top: 10px\">";
                            div += "<div class=\"card-header pl-0 pr-0\">"
                                div += "<div class=\"row no-gutters w-100 align-items-center\">";
                                    div += "<div class=\"col ml-3\">"+post.title+"</div>";
                                    div += "<div class=\"col-4 text-muted\">";
                                        div += "<div class=\"row no-gutters align-items-center\">";
                                            div += "<div class=\"col-md-4 offset-2\">Comentarios</div>";
                                        div += "</div>";
                                    div += "</div>";
                                div += "</div>";
                            div += "</div>";
                            div += "<hr class=\"m-0\">";
                            div += "<div class=\"card-body py-3\">";
                                div += "<div class=\"row no-gutters align-items-center\">";
                                    div += "<div class=\"col\"> <a href=\""+base+"/post/"+post.post_id+"/"+post.slug+"\" class=\"text-big\" data-abc=\"true\">"+post.details.substr(0,50)+"...\</a>";
                                        div += "<div class=\"text-muted small mt-1\">"+moment(post.post_created_at).format('LL')+" &nbsp;·&nbsp; <a href=\"javascript:void(0)\" class=\"text-muted\" data-abc=\"true\" style=\"text-decoration: none; cursor:auto;\">"+post.email+"</a></div>";
                                        div += "<div class=\"text-muted small mt-1\">"+post.career_name+" &nbsp;·&nbsp; <a href=\"javascript:void(0)\" class=\"text-muted\" data-abc=\"true\" style=\"text-decoration: none; cursor:auto;\">" +post.subject_name+"</a></div>";
                                    div += "</div>";
                                    div += "<div class=\"d-none d-md-block col-2\">";
                                        div += "<div class=\"row no-gutters align-items-center\">";
                                            div += "<div class=\"col-12\"><a href=\"javascript:void(0)\" class=\"text-muted\" data-abc=\"true\" style=\"text-decoration: none;\">0</a></div>";
                                        div += "</div>";
                                    div += "</div>";
                                    div += "<div class=\"col-1\">";
                                        if (post.status == 0) {div += "<span class=\"badge badge-primary\">Publico</span>"}
                                        else {div += "<span class=\"badge badge-danger\">Finalizado</span>"}
                                    div += "</div>";
                                div += "</div>";
                            div += "</div>";
                        div += "</div>";
                    div += "</div>";
                div += "</div>";
                posts_lists.innerHTML += div;
            });
        } else{
            //mensaje de error
        }


    }
}
