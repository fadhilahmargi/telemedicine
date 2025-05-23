$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#searchField').on('keyup', function () {
        let searchValue = $(this).val();

        $.ajax({
            url: '/search',
            type: 'GET',
            data: { search: searchValue },
            success: function (response) {
                $('#results').empty();
                response.forEach(user => {
                    console.log(user);
                    let resultEl = `<div class="flex items-center hover:bg-[#202532] cursor-pointer transition duration-150 ease-out hover:ease-in rounded h-[50px]">
                                        <img src="/images/${user.profileImage}" class="rounded-full w-[30px] h-[30px] ml-2">
                                        <a href="/profile/${user.username}"><span class="px-2 text-white text-[14px]">${user.name}</span></a>
                                    </div>;`
                    $('#results').append(resultEl);
                })
            }
        })
    })
});
