/*Created by Sergey Brilenko*/
(function( $ ){
	$.fn.user = function(options){
       var active;
       var istouch,ishover, arrowis;
       if((!!('ontouchstart' in window)))
       {
            istouch='touchend';
            ishover='focusout';
            arrowis='touchstart'
       }
       else
       {
            istouch='click';
            ishover='focusout';
            arrowis='click'
       }
		var options = $.extend({
		}, options || {});
        
        
		var user={
		    init:function($this)
            {
            },
            ajaxsender:function(ajaxdata,f_)
            {
                $.ajax({
    			url: "/ajax.php",
    			type: "post",
                dataType: 'json',
                data:ajaxdata,
    			async: false,
    			success:f_
		      })
            }
		}
        //if($('#nextuser').data('au')=='none') { active=20} else {active=parseInt($('#nextuser').data('au')-1)}
        this.on(istouch,function(){  user.init($(this))})
        this.on(ishover,function(){
        var name=$('#user').val();
        user.ajaxsender({action:'user',name_:name},function(data)
        {
            //console.log(data);
        });
        })
        $('#nextuser').on(istouch,function()
        {
            var $this=$(this)
            if($this.hasClass('active'))
            {
            if(!$this.hasClass('disabled'))
            {
                $this.addClass('disabled')
                user.ajaxsender({action:'usernext',a:active},function(data)
                {
                    console.log(data)
                    $this.removeClass('disabled')
                    if(parseInt(data['active'])>=19)
                    {
                      $this.removeClass('active')
                    }
                    if(parseInt(data['active'])>0)
                    {
                        $('#prevuser').addClass('active')
                    }
                    $('#user').val(data['name'])
                    $('.zakazname').text("Заказ "+data['name']+":");
                    $('.zakazkol').text("Количество товаров - "+data['kol']);
                    $('.zakazsum').text(data['price']+" грн");
                    $('.zakaztotal').text(data['total']+" грн")
                    if(data['ids'].length>0)
                    {
                        $('.products li').each(function(index)
                        {
                            var id=$('input[type=hidden]',$(this)).val()
                            for(var i=0;i<=data['ids'].length-1;i++)
                            {
                                if(data['ids'][i]['id']==id)
                                {
                                    $('.val',$(this)).text(data['ids'][i]['k'])
                                    $('.priced',$(this)).text(Math.round((data['ids'][i]['k']*data['ids'][i]['price']-data['ids'][i]['k']*data['ids'][i]['price']*((data['discount'])/100).toFixed(2)).toFixed(3)*100)/100)
                                    $('.buy',$(this)).replaceWith('<a href="/cart" class="buyp disabled">В корзине</a>')
                                    $('.plus',$(this)).attr('disabled','disabled')
                                    $('.minus',$(this)).attr('disabled','disabled')
                                    break;
                                }
                                else
                                {
                                    var price=parseFloat($('.plus',$(this)).data('price')).toFixed(2)
                                    $('.val',$(this)).text('1')
                                    $('.priced',$(this)).text(price)
                                    $('.buyp',$(this)).replaceWith('<span class="buy">Купить</span>')
                                    $('.plus',$(this)).removeAttr('disabled')
                                    $('.minus',$(this)).removeAttr('disabled')
                                }
                            }
                        })
                    }
                    else
                    {
                        $('.products li').each(function(index)
                        {
                            var id=$('input[type=hidden]',$(this)).val()
                            var price=parseFloat($('.plus',$(this)).data('price')).toFixed(2)
                            $('.val',$(this)).text('1')
                            $('.priced',$(this)).text(price)
                            $('.buyp',$(this)).replaceWith('<span class="buy">Купить</span>')
                            $('.plus',$(this)).removeAttr('disabled')
                            $('.minus',$(this)).removeAttr('disabled')
                        })
                    }
                } );
            }
            }
            
            
        })
        $('#prevuser').on(istouch,function()
        {
            var $this=$(this)
            if($this.hasClass('active'))
            {
            if(!$this.hasClass('disabled'))
            {
                $this.addClass('disabled')
                user.ajaxsender({action:'userprev'},function(data)
                {
                    console.log(data)
                    $this.removeClass('disabled')
                    if(parseInt(data['active'])<=0)
                    {
                      $this.removeClass('active')
                    }
                    if(parseInt(data['active'])<20)
                    {
                        $('#nextuser').addClass('active')
                    }
                    $('#user').val(data['name'])
                    $('.zakazname').text("Заказ "+data['name']+":");
                    $('.zakazkol').text("Количество товаров - "+data['kol']);
                    $('.zakazsum').text(data['price']+" грн");
                    $('.zakaztotal').text(data['total']+" грн")
                    if(data['ids'].length>0)
                    {
                        $('.products li').each(function(index)
                        {
                            var id=$('input[type=hidden]',$(this)).val()
                            for(var i=0;i<=data['ids'].length-1;i++)
                            {
                                if(data['ids'][i]['id']==id)
                                {
                                    $('.val',this).text(data['ids'][i]['k'])
                                    console.log(data['ids'][i]['k'],data['ids'][i]['price'],data['discount'])
                                    $('.priced',$(this)).text(Math.round((data['ids'][i]['k']*data['ids'][i]['price']-data['ids'][i]['k']*data['ids'][i]['price']*((data['discount'])/100).toFixed(2)).toFixed(3)*100)/100)
                                    $('.buy',$(this)).replaceWith('<a href="/cart" class="buyp disabled">В корзине</a>') 
                                    $('.plus',$(this)).attr('disabled','disabled')
                                    $('.minus',$(this)).attr('disabled','disabled')                                   
                                    break;
                                }
                                else
                                {
                                    var price=parseFloat($('.plus',$(this)).data('price')).toFixed(2)
                                    $('.val',$(this)).text('1')
                                    $('.priced',$(this)).text(price)
                                    $('.buyp',$(this)).replaceWith('<span class="buy">Купить</span>')
                                    $('.plus',$(this)).removeAttr('disabled')
                                    $('.minus',$(this)).removeAttr('disabled')
                                }                                                               
                            }
                        })
                    }
                    else
                    {
                        $('.products li').each(function(index)
                        {
                            var id=$('input[type=hidden]',$(this)).val()
                            var price=parseFloat($('.plus',$(this)).data('price')).toFixed(2)
                            $('.val',$(this)).text('1')
                            $('.priced',$(this)).text(price)
                            $('.buyp',$(this)).replaceWith('<span class="buy">Купить</span>')
                            $('.plus',$(this)).removeAttr('disabled')
                            $('.minus',$(this)).removeAttr('disabled')
                        })
                    }
                    $('#user').val(data['name'])
                    $('.zakazname').text('Заказ '+data['name']+': ')
                    $('.zakazkol').text('Количество товаров - '+data['kol'])
                    $('.zakazsum').text(data['price']+' грн')
                    $('.zakaztotal').text(data['total']+' грн') 
                } );
            }
            }
            
            
        })
        
        $(document).on(istouch,'.buy',function(){
            var $t=$(this);
            var id=parseInt($(this).prev().val())
            var pl=$('.plus',$t.parent())
            var minus=$('.minus',$t.parent())
            pl.attr('disabled','disabled')
            minus.attr('disabled','disabled')
            $t.addClass('disabled');
            var $k=parseInt($('span',$(this).parent()).text())
            var optionsUpdate = {
            url:    "/addcart.php",
            beforeSubmit: function(jqForm) {
                var ob=new Object(); ob.name='k_';ob.value=$k;jqForm.push(ob);
            },
            success: function(data) {
                data=$.parseJSON(data);
    			if(data)
                    {
                        if(data['is']==1)
                        {
                            location.href='/cart'
                        }
                        else
                        {
                            $('.buy').each(function()
                            {
                                if(id==parseInt($(this).prev().val()))
                                {
                                    $(this).replaceWith('<a href="/cart" class="buyp disabled">В корзине</a>')
                                }
                            })
                            $('.priced',$t.parent().parent().prev()).text(data['pricethis'])
                            $('.zakazname').text('Заказ '+data['name']+': ')
                            $('.zakazkol').text('Количество товаров - '+data['kol'])
                            $('.zakazsum').text(data['price']+' грн')
                            $('.zakaztotal').text(data['total']+' грн') 
                            $t.replaceWith('<a href="/cart" class="buyp disabled">В корзине</a>')
                        }
                        
                    }
                    else
                    {
                         $t.removeClass('disabled');
                         plmin.removeAttr('disabled')
                    }
            }
        };
            $t.parent().parent().ajaxSubmit(optionsUpdate); 
            return false;
    

            /*var $thisb=$(this)
            if(!$thisb.hasClass('disabled'))
            {
                $thisb.addClass('disabled')
                var k=parseInt($('span',$(this).parent()).text());
                var id=$(this).data('id');
                user.ajaxsender({action:'buy',k_:k,id_:id},function(data){{
                            if(data)
                            {
                                $('.zakazname').text('Заказ '+data['name']+': ')
                                $('.zakazkol').text('Количество товаров - '+data['kol'])
                                $('.zakazsum').text(data['price']+' грн')
                                $('.zakaztotal').text(data['total']+' грн') 
                                $thisb.replaceWith('<a href="/cart" data-id=\''+id+'\' class="buyp disabled">В корзине</a>')
                            }
                            else
                            {
                                $thisb.removeClass('disabled');
                            }
                            
                        } })
               
            }**/
            
        })
        
	}
})(jQuery);
$(function()
{
    $('#user').user() 
})		