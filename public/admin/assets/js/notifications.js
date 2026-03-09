/**
 * ========================================
 * NOTIFICATIONS PAGE JAVASCRIPT
 * ========================================
 */

(function() {
    'use strict';

    // ========================================
    // SELECT ALL FUNCTIONALITY
    // ========================================
    $(document).on('change', '.selectAll input', function() {
        if (this.checked) {
            $(".checkSingle input").each(function(index, element) {
                $(this).prop('checked', true);
            });
        } else {
            $(".checkSingle input").each(function() {
                $(this).prop('checked', false);
            });
        }
    });

    $(document).on('change', '.checkSingle input', function() {
        if (!this.checked) {
            $('.selectAll input').prop('checked', false);
        } else {
            var isAllChecked = 0;
            $(".checkSingle input").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });
            if (isAllChecked == 0) {
                $('.selectAll input').prop("checked", true);
            }
        }
    });

    // ========================================
    // HIDE NO-DATA IF NOTIFICATIONS EXIST
    // ========================================
    if ($('.mail-read').length > 0) {
        $('.no-data').fadeOut();
    }

    // ========================================
    // CLICK ON NOTIFICATION TO GO TO URL
    // ========================================
    $(document).on('click', '.mail-read', function(e) {
        // تجاهل الضغط إذا كان على checkbox أو زر الحذف
        if ($(e.target).closest('.checkSingle, .delete-single-notification').length > 0) {
            return;
        }

        // الحصول على الـ URL من data attribute
        var notificationUrl = $(this).find('.media-body').data('url');
        
        // إذا كان هناك URL وليس '#'، انتقل إليه
        if (notificationUrl && notificationUrl !== '#') {
            window.location.href = notificationUrl;
        }
    });

    // ========================================
    // DELETE SINGLE NOTIFICATION
    // ========================================
    $(document).on('click', '.delete-single-notification', function(e) {
        e.preventDefault();
        e.stopPropagation(); // منع تفعيل click على الإشعار
        
        var notificationId = $(this).data('id');
        var notificationElement = $(this).closest('.mail-read');
        var hrElement = notificationElement.next('hr');

        Swal.fire({
            title: window.translations?.are_you_sure || "هل أنت متأكد؟",
            text: window.translations?.you_will_not_be_able_to_revert_this || "لن تتمكن من التراجع عن هذا",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: window.translations?.yes_delete_it || 'نعم، احذفه',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonText: window.translations?.cancel || 'إلغاء',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: window.routes?.deleteNotifications || '/admin/delete-notifications',
                    data: {
                        data: JSON.stringify([{id: notificationId}])
                    },
                    success: function(msg) {
                        Swal.fire({
                            position: 'top-start',
                            type: 'success',
                            title: window.translations?.deleted_successfully || 'تم الحذف بنجاح',
                            showConfirmButton: false,
                            timer: 1500,
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                        });

                        // حذف العنصر من الصفحة
                        hrElement.fadeOut(300, function() {
                            $(this).remove();
                        });
                        notificationElement.fadeOut(300, function() {
                            $(this).remove();

                            // إذا لم يتبقى أي إشعارات، إظهار رسالة "لا توجد بيانات"
                            if ($(".mail-read").length == 0) {
                                $('.no-data').fadeIn();
                                $('.app-action').remove();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            type: 'error',
                            title: window.translations?.error || 'خطأ',
                            text: window.translations?.something_went_wrong || 'حدث خطأ ما',
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                        });
                    }
                });
            }
        });
    });

    // ========================================
    // DELETE MULTIPLE NOTIFICATIONS
    // ========================================
    $('.delete_all_button').on('click', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: window.translations?.are_you_sure || "هل تريد الاستمرار؟",
            text: window.translations?.are_you_sure_text || "هل أنت متأكد أنك تريد استكمال عملية حذف المحدد",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: window.translations?.confirm || 'تأكيد',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonText: window.translations?.cancel || 'إلغاء',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        }).then((result) => {
            if (result.value) {
                var usersIds = [];
                $('.checkSingle input:checked').each(function() {
                    var id = $(this).attr('id');
                    usersIds.push({
                        id: id,
                    });
                });

                var requestData = JSON.stringify(usersIds);
                if (usersIds.length > 0) {
                    $.ajax({
                        type: "POST",
                        url: window.routes?.deleteNotifications || '/admin/delete-notifications',
                        data: {
                            data: requestData
                        },
                        success: function(msg) {
                            Swal.fire({
                                position: 'top-start',
                                type: 'success',
                                title: window.translations?.the_selected_has_been_successfully_deleted || 'تم حذف المحدد بنجاح',
                                showConfirmButton: false,
                                timer: 1500,
                                confirmButtonClass: 'btn btn-primary',
                                buttonsStyling: false,
                            });

                            $('.checkSingle input:checked').each(function() {
                                $(this).parents('.mail-read').next('hr').fadeOut(300, function() {
                                    $(this).remove();
                                });
                                $(this).parents('.mail-read').fadeOut(300, function() {
                                    $(this).remove();
                                });
                            });

                            setTimeout(function() {
                                if ($(".checkSingle input").length == 0) {
                                    $('.no-data').fadeIn();
                                    $('.app-action').remove();
                                }
                            }, 400);
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                type: 'error',
                                title: window.translations?.error || 'خطأ',
                                text: window.translations?.something_went_wrong || 'حدث خطأ ما',
                                confirmButtonClass: 'btn btn-primary',
                                buttonsStyling: false,
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        type: 'warning',
                        title: window.translations?.warning || 'تحذير',
                        text: window.translations?.please_select_items || 'الرجاء تحديد عناصر للحذف',
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                    });
                }
            }
        });
    });

})();
