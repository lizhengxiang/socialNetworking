//小提示框
$("[data-toggle='tooltip']").tooltip();
$('*').darkTooltip({
});

(function( $ ) {
    //用于处理图片流
    var $container = $('.masonry-container');
    $container.imagesLoaded( function () {
        $container.masonry({
            columnWidth: '.item',
            itemSelector: '.item'
        });
    });
    //Reinitialize masonry inside each panel after the relative tab link is clicked -
    $('a[data-toggle=tab]').each(function () {
        var $this = $(this);
        $this.on('shown.bs.tab', function () {
            $container.imagesLoaded( function () {
                $container.masonry({
                    columnWidth: '.item',
                    itemSelector: '.item'
                });
            });

        }); //end shown
    });  //end each

    //绑定数据
    var vm = new Vue({
        el: '#homedata',
        data: {
            a: 1
        },
        computed: {
            // 一个计算属性的 getter
            b: function () {
                // `this` 指向 vm 实例
                return this.a + 1
            }
        }
    })

})(jQuery);