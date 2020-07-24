$(document).ready(function () {

    /* Переменная-флаг для отслеживания того, происходит ли в данный момент ajax-запрос. В самом начале даем ей значение false, т.е. запрос не в процессе выполнения */
    var inProgress = false;
    /* С какой статьи надо делать выборку из базы при ajax-запросе */
    var startFrom = 5;
    var pPage = 1;

    $(window).scroll(function () {

        /* Если высота окна + высота прокрутки больше или равны высоте всего документа и ajax-запрос в настоящий момент не выполняется, то запускаем ajax-запрос */
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !inProgress) {

            $.ajax({
                /* адрес файла-обработчика запроса */
                url: 'load_posts.php',
                /* метод отправки данных */
                method: 'POST',
                /* данные, которые мы передаем в файл-обработчик */
                dataType: "json",
                data: {
                    "startFrom": startFrom,
                    "pPage": pPage
                },
                /* что нужно сделать до отправки запрса */
                beforeSend: function () {
                    /* меняем значение флага на true, т.е. запрос сейчас в процессе выполнения */
                    inProgress = true;
                    /* что нужно сделать по факту выполнения запроса */
                },
                success: function (data) {
                    if (data.result == "success") {
                        $(".posts").append(data.html);
                        // Увеличиваем на 10 порядковый номер статьи, с которой надо начинать выборку из базы
                        pPage = pPage + 1;
                        /* По факту окончания запроса снова меняем значение флага на false */
                        inProgress = false;
                    }
                },
                error: function (data){
                    console.log("Error", data);
                }
            });
        }
    });

});