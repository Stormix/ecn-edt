@extends('home')
@section('progress')
    <div class="row">
        @if ($status->status == 'queued')
            <div class="alert alert-info">
                {{ trans("laravel-job-status::progress.submitted", ['name' => trans($status->type)]) }}
            </div>
        @elseif ($status->status == 'executing')
            <div class="alert alert-info">
                {{ trans("laravel-job-status::progress.processing", ['name' => trans($status->type)]) }}
            </div>
        @elseif ($status->status == 'finished')
            @if (isset($status->output['success_rows']))
                @if ($status->output['failed_rows'] == 0)
                    <div class="alert alert-success">
                        <p>{{ trans("laravel-job-status::progress.finished", ['name' => trans($status->type)]) }}</p>
                        <p>{{ sprintf(trans("laravel-job-status::progress.result_numbers"), $status->output['total_rows'], $status->output['success_rows'], $status->output['skipped_rows'], $status->output['failed_rows']) }}</p>
                    </div>
                @elseif ($status->output['success_rows'] == 0)
                    <div class="alert alert-danger">
                        <p>{{ trans("laravel-job-status::progress.all_failed", ['name' => trans($status->type)]) }}</p>
                        <p>{{ sprintf(trans("laravel-job-status::progress.result_numbers"), $status->output['total_rows'], $status->output['success_rows'], $status->output['skipped_rows'], $status->output['failed_rows']) }}</p>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <p>{{ trans("laravel-job-status::progress.partially_finished", ['name' => trans($status->type)]) }}</p>
                        <p>{{ sprintf(trans("laravel-job-status::progress.result_numbers"), $status->output['total_rows'], $status->output['success_rows'], $status->output['skipped_rows'], $status->output['failed_rows']) }}</p>
                    </div>
                @endif
            @else
                <div class="alert alert-success">
                    <p>{{ trans("laravel-job-status::progress.finished", ['name' => trans($status->type)]) }}</p>
                </div>
            @endif
        @elseif ($status->status == 'failed')
            <div class="alert alert-danger">
                {{ $status->output['message'] }}
            </div>
        @endif

        @if (!empty($status->output['errors']))
            <p><textarea class="form-control bg-danger" rows="10">{!! implode(PHP_EOL, $status->output['errors']) !!}</textarea></p>
        @endif

        <div class="progress">
            <div class="progress-bar {{ $status->isEnded ?: 'progress-bar-striped progress-bar-animated' }}" role="progressbar" style="width: {{ $status->progress_percentage }}%;">
                <span>{{ $status->progress_now }} / {{ $status->progress_max }}</span>
            </div>
        </div>
        @if (!$status->isEnded)
            <script>
                setTimeout(function () {
                    document.location.href = document.location;
                }, 3000);
            </script>
        @endif
        </div>
@endsection
