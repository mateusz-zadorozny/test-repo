const nav = document.querySelector('.site-header');
const navTop = nav.offsetTop + 120;

function stickyNavigation() {
    if (window.scrollY >= navTop) {
        document.body.classList.add('fixed-nav');
    } else {
        document.body.classList.remove('fixed-nav');
    }
}

window.addEventListener('scroll', stickyNavigation);


(function (jQuery) {
    window.$ = jQuery
})(jQuery);

var getParamsToUrl = function (form) {
    return form.serialize();

};

var afterFiltersFormSent = function (data, form) {
    if (data.success == false) {
        return;
    }

    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + getParamsToUrl(form);
    window.history.pushState({ path: newurl }, '', newurl);
    $(".filters-list-items").html(data.items);
    $(".pagination-container").html(data.pagination);
    $('.filters-list-items').removeClass('list-loading');

}

var submitFiltersForm = function (form, type) {
    var formData = form.serializeArray();
    $('.filters-list-items').addClass('list-loading');
    formData.push({ 'name': 'afp_nonce', 'value': postSearchParams.afp_nonce });
    formData.push({ 'name': 'action', 'value': type });
    $.ajax({
        url: postSearchParams.ajax_url,
        data: formData,
        type: 'POST',
        success: function (data) {
            data = JSON.parse(data);
            afterFiltersFormSent(data, form);

        }
    });

}
var pageChange = function (el, type) {
    var page = $(el).attr('data-page');
    $('#' + type + '-filters [name=page]').val(page);
    var form = $('#' + type + '-filters');
    submitFiltersForm(form, type + "_search");
}

$('.select2').select2({
    placeholder: function () {
        $(this).data('placeholder');
    },
    allowClear: true,
    closeOnSelect: false
});

var toggleCategory = function (el, type) {
    var selectedCategory = $(el).attr('data-category');
    var oldCategory = $('#' + type + '-filters [name=category]').val();
    $('#' + type + '-filters [name=category]').val(selectedCategory);

    if (oldCategory === selectedCategory) {
        $('#' + type + '-filters [name=category]').val("")
    }

    $('#' + type + '-filters [name=page]').val("1")

    var form = $('#' + type + '-filters');
    submitFiltersForm(form, type + "_search");
}

var setSearch = function (el, type) {
    var search = $(el).val();
    $('#' + type + '-filters [name=search]').val(search);

    var form = $('#' + type + '-filters');
    submitFiltersForm(form, type + "_search");
}


var debounce = function (func, wait, immediate) {
    var timeout;

    return function () {
        var context = this, args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) {
                func.apply(context, args);
            }
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) {
            func.apply(context, args);
        }
    };
};

$(document).on('change', '#posts-filters select', function () {
    var form = $('#posts-filters');
    $('#posts-filters [name=page]').val(1);

    submitFiltersForm(form, 'posts_search');

});

$(document).on('click', '#posts .pagination a', function (evt) {
    evt.preventDefault();
    pageChange(this, 'posts');
});

$(document).on('click', '#posts .search-reset', function (evt) {
    evt.preventDefault();
    var form = $('#posts-filters');
    $('#posts-filters [name=page]').val(1);
    $('#posts-filters [name=s]').val("");

    submitFiltersForm(form, 'posts_search');
});

$(document).on('click', '.blog-search-group button', function (evt) {
    evt.preventDefault();

    var form = $('#posts-filters'),
        searchInput = $('.blog-search-input'),
        search = searchInput.val(),
        listOffset = form.offset().top - 92,
        scroll = $('body').scrollTop();

    $('#posts-filters [name=s]').val(search);
    $('#posts-filters [name=page]').val(1);
    submitFiltersForm(form, 'posts_search');


    searchInput.val('');
    $("html, body").animate({
        scrollTop: scroll + listOffset,
    }, 500);
});

// $(document).on('click', '.pll-parent-menu-item', function () {
//     $('.pll-parent-menu-item').toggleClass('sfHover');
//     $('.sub-menu').toggleClass('toggled-on');
// })

$(document).on('mouseenter', '.post-card__hover .post-card', function () {
    $(this).parent().parent().addClass('hover-container-active');
});
$(document).on('mouseleave', '.post-card__hover .post-card', function () {
    $(this).parent().parent().removeClass('hover-container-active');
});

$(document).on('click', '.category-block', function (evt) {
    evt.preventDefault();

    let categoryId = $(this).attr('data-term-id'),
        form = $('[name=products-list]');

    $('.category-block.active').removeClass('active');
    $(this).addClass('active');
    $('[name=category]').val(categoryId);

    submitFiltersForm(form, 'products_search');

});


$(document).ready(function(){
    $('.ff-btn, .button').wrapInner( "<span></span>");

    $('.select2, .fluentform select:not(.choices__input)').select2({
        closeOnSelect: true
    });

    if (window.location.href.indexOf("?category=") > -1) {
        window.scrollTo($('#products-section'), 1000);
    }

    if ($('.entry-header').length && !$('body').hasClass('search-no-results')){
        $('body').addClass('light-header');
    }

})


// $('.parallax-window').parallax();

$(document).on("ready", function(){
    
    var buyBtns = $("body").find(".buy-by-stripe");
    if (buyBtns.length === 0) {
        return;
    }
    buyBtns.each(function(idx, el){
        var stripeForm = $('.stripe-form form');
        if (stripeForm.length === 0) {
            $(el).remove();
        }
    });
    
});
$(document).on("click", ".buy-by-stripe", function(evt) {
    evt.preventDefault(); 
    $('.stripe-form form').submit();
});

$(document).on("click", ".info-box .close", function(evt) {
    evt.preventDefault();
    $('.info-box').hide();
    $('body').removeClass('with-info-box');
    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
    window.history.pushState({ path: newurl }, '', newurl);
}); 

var toggleJobPositions = function() {
    let toHide = [],
        toShow = [];

    const catId = $('select[name=job_position_list_categories]').val(),
          localizationId = $('select[name=job_position_list_localizations]').val();
    
    $('.open-positions-banner__item').each(function(idx, el) {
        let id = $(el).attr('data-job-id'),
            categories = $(el).attr('data-categories').split('|'),
            localizations = $(el).attr('data-localizations').split('|');
            
        if (('-' === catId || categories.includes(catId)) && ('-' === localizationId || localizations.includes(localizationId))) {
            toShow.push(id);
        } else {
            toHide.push(id);
        }
    });
    
    toHide.forEach(function(id){
        $('[data-job-id='+id+']').hide();
    });
    
    toShow.forEach(function(id){
        $('[data-job-id='+id+']').show();
    });
}

$(document).on('change', 'select[name=job_position_list_categories]', function () {
    toggleJobPositions();
});

$(document).on('change', 'select[name=job_position_list_localizations]', function () {
    toggleJobPositions();
});

$(document).on('click', '.social-share-fb', function (e) {
    e.preventDefault();
    var url = 'https://www.facebook.com/share.php?u=' + $(this).attr('data-href');
    window.open(url, '_blank', 'width=400,height=500');
    return false;
});

$(document).on('click', '.social-share-linkedin', function (e) {
    e.preventDefault();
    var url = "https://www.linkedin.com/sharing/share-offsite/?url=" + $(this).attr('data-href');
    window.open(url, '_blank', 'width=400,height=500');
    return false;
});

$(document).on('click', '.search-categories button', function (evt) {
    evt.preventDefault();
    var rel = $(this).attr('data-rel'),
        results = $('body').find('.search-results');

    $('.search-categories button').removeClass('active');
    $(this).addClass('active');

    if (rel === 'all') { 
        $('.search-results').show(); 
        return;
    }

    
    $(results).each(function(idx, el){
        var id= $(el).attr('id');
        if (id === 'search-' + rel) {
            $(el).show();
            
        } else {
            $(el).hide();
        }
    });
    
});
