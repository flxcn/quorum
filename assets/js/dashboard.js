$(document).ready(function(){

    getOngoingVotes();

    setInterval(function(){
        getOngoingVotes();
    }, 5000);

    function getOngoingVotes()
    {
        $.ajax({
            url:"get-active-votes.php",
            method:"POST",
            data: {},
            success:function(data){
                var html = '';
                var count = Object.keys(data).length;
                $.each(data, function(key, value){

                    html += '<div class="card bg-white">';
                    html += '    <div class="card-header bg-white text-black"><b>'+ value.title +'</b></div>';
                    html += '    <div class="card-body overflow-auto" id="messagesArea">';
                    html += '        <p>Proposed by: <b>' + value.sponsor + ' (' + value.caucus + ')</b></p>';
                    html += '        <p>'+ value.description + '</p>';
                    html += '        <p><a target="_blank" href="'+ value.link + '">See text of amendment</a></p>';
                    html += '        <p class="card-text"><i>Remember, amendments require 3/4 of delegates to pass.</i></p>';
                    html += '    </div>';
                    html += '    <div class="card-footer overflow-auto bg-white">';
                    if(value.is_open_for_delegates) {
                        html += '        <a class="btn btn-success" href="delegate-vote.php?vote_id=' + value.vote_id + '">Vote as a Delegate</a>';
                    }
                    if(value.is_open_for_caucuses) {
                        html += '        <a class="btn btn-primary" href="caucus-vote.php?vote_id=' + value.vote_id + '">Vote as a Caucus</a>';
                    }
                    html += '    </div>';
                    html += '</div>';
                });
                $('#ongoingVotesCount').html(count);
                $('#ongoingVotes').html(html);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }     
        })
    }
}); 