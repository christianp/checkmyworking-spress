var container = document.getElementById('search-container');
var results_ul = document.getElementById('results');

function Searcher() {
    this.get_args();
    this.show_query();
    if(this.query==localStorage['search-query']) {
        this.restore();
    } else {
        this.build_index();
        this.search();
    }
}
Searcher.prototype = {
    get_args: function() {
        var bits = window.location.search.slice(1).split('&');
        var out = {};
        bits.forEach(function(b) {
            var bit = b.split('=');
            var name = decodeURIComponent(bit[0]);
            var value = decodeURIComponent(bit[1]).replace('+',' ');
            out[name] = value;
        });
        this.args = out;
        this.query = this.args['q'];
        return out;
    },
    show_query: function() {
        var s = this;
        Array.prototype.forEach.apply(container.querySelectorAll('.query'),[function(q) { 
            q.textContent = s.query; 
        }]);
    },
    restore: function() {
        results_ul.innerHTML = localStorage['search-cached-results'];
        container.className = localStorage['search-cached-class'];
    },

    build_index: function() {
        var s = this;
        if(this.index) {
            return;
        }
        this.index = lunr(function() {
            this.field('title',{boost:10});
            this.field('body');
            this.ref('url');
        });
        this.content_dict = {};
        content.forEach(function(d) {
            if(!d.draft) {
                s.content_dict[d.url] = d;
                s.index.add(d);
            }
        });
    },

    search: function() {
        var s = this;

        var results = this.index.search(this.query);

        results_ul.innerHTML = '';
        container.className = results.length ? 'got-results' : 'no-results';

        results.forEach(function(r) {
            var p = s.content_dict[r.ref];
            var html = '<h3 class="posttitle"><a href="'+p.url+'">'+p.title+'</a></h3>\n<div class="content">'+p.excerpt+'</div>';
            var li = document.createElement('article');
            li.innerHTML = html;
            results_ul.appendChild(li);
        });

        localStorage['search-cached-results'] = results_ul.innerHTML;
        localStorage['search-cached-class'] = container.className;
        localStorage['search-query'] = this.query;
    }
}

var searcher = new Searcher();
