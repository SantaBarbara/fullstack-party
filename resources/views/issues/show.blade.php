@extends('layout')

@section('content')
    <section class="issue-show">
        <div class="container">
            <div class="header">
                <a  href="{{ route('issues') }}" class="back">
                    <i class="icon icon-back is-success"></i>
                    <span>Back to Issues</span>
                </a>
            </div>

            <div class="issue">
                        <div class="information">
                            <div class="name">
                                <a href="">
                                    {{ $issue['title'] }}
                                    <span class="issue-number">#{{ $issue['number'] }}</span>
                                </a>
                            </div>
                            <div class="notes">
                                <span class="button is-small @if($issue['state'] == 'open') is-danger @else is-success @endif mr-1">
                                    <span class="icon icon-exclamation-circle"></span>
                                    <span>{{ ucfirst($issue['state']) }}</span>
                                </span>
                                <a href="{{ $issue['user']['url'] }}" target="_blank">{{ $issue['user']['login'] }}</a>
                                &nbsp; opened this issue {{ \Carbon\Carbon::parse($issue['created_at'])->diffForHumans() }}
                                - {{ $issue['comments'] }} {{ trans_choice('common.comments', $issue['comments']) }}
                            </div>
                        </div>
                    </div>

            @if($comments->count())
            <div class="comments">
                @foreach($comments as $comment)
                <div class="comment">
                    <a href="{{ $comment['user']['url'] }}"
                       class="avatar"
                       style="background-image: url('{{ $comment['user']['avatar_url'] }}');"
                    ></a>
                    <div class="box">
                        <div class="header">
                            <a href="{{ $comment['user']['url'] }}" target="_blank">{{ $comment['user']['login'] }}</a>
                            commented {{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}
                        </div>
                        <div class="body">
                            {!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($comment['body']) !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{ $comments->links('pagination.bulma') }}
            @endif
        </div>
    </section>
@endsection
