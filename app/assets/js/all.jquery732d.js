var Win = jQuery(window),
    Doc = jQuery(document);

var Global = {
    redirect: function(to, out = false) {
        if (!out) to = site.url + to;
        location.href = to;
    },
    reload: function() {
        location.reload();
    },
    mask: function(type) {
        if (type == 'show') {
            jQuery('.mask').fadeIn(0);
        } else if (type == 'hide') {
            jQuery('.mask').fadeOut(0);
        }
    }
};

var LHash = {
    get: function() {
        return location.hash;
    },
    set: function(val) {
        location.hash = val;
    },
    remove: function() {
        var scrollV, scrollH;

        if ("pushState" in history) {
            history.pushState("", document.title, window.location.pathname + window.location.search);
        } else {
            scrollV = Doc.scrollTop();
            scrollH = Doc.scrollLeft();

            LHash.set('');

            Doc.scrollTop() = scrollV;
            Doc.scrollLeft() = scrollH;
        }
    }
};

var Get = {
    scrollbar_position: function(dir) {
        var out = '';

        if (dir == 'y') {
            out = Doc.scrollTop();
        } else if (dir == 'x') {
            out = Doc.scrollLeft();
        } else {
            out = 'y:' + Doc.scrollTop() + ',x:' + Doc.scrollLeft();
        }

        return out;
    }
};

var Err = {
    cache: jQuery('.errorCache'),
    title: jQuery('.errorCache > .box > .title > span'),
    msg: jQuery('.errorCache > .box > .content > p'),

    new: function(message, type = 'error') {
        if (type == 'success') {
            Err.title.text('Félicitations !');
            Err.cache.addClass('success');
        } else {
            Err.title.text('Ooops, une erreur est survenue');
            Err.cache.removeClass('success');
        }

        Err.msg.html(message);
        Err.cache.fadeIn(200);
    },
    remove: function() {
        Err.cache.fadeOut(200, function() {
            Err.msg.html('');
        });
    }
};

var Radio = {
    auto: jQuery('.radio.insertion > .content > audio'),

    switch_pp: function() {
        if (Radio.auto.prop('volume') == "0.0") {
            Radio.auto.prop("volume", 1.0);
            jQuery('.player_control').addClass('fa-pause');
            jQuery('.player_control').removeClass('fa-play');

            Radio.update_autoplay_db('play');
        } else {
            Radio.auto.prop("volume", 0.0);
            jQuery('.player_control').addClass('fa-play');
            jQuery('.player_control').removeClass('fa-pause');

            Radio.update_autoplay_db('pause');
        }
    },
    update_autoplay_db: function(value) {
        jQuery.post(site.url + '/app/core/ajax/update_autoplay_radio.php', { value : value }, function(data) {
            if (data.error) {
                console.error(data.message);
            } else {
                console.log(data.message);
            }
        }, 'json');
    },
    song_infos: function() {
        jQuery.get('http://openskyradio.fr/player/plugins/title.php', function(data) {
            var artist = data.artists
              , title = data.title
              , cover = data.cover;

            jQuery('.song.title').text(title);
            jQuery('.song.artist').text(artist);
            jQuery('.song.cover').attr('style', 'background-image:url("' + cover + '");');
        }, 'json');
    }
};

jQuery(function() {
    Doc.on('click', '.errorCache,.croix_cec', function() {
        Err.remove();
    });

    Doc.on('click', '.errorCache > *', function() {
        return false;
    });

    jQuery('body').removeClass('preload');
});