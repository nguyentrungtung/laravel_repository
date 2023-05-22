<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Bus\PendingDispatch;
use SplPriorityQueue;

class QueueJobBuilder
{
    protected $queue;

    public function __construct()
    {
        $this->queue = new SplPriorityQueue();
    }

    public function addJob($job, $data = [], $queue = null, $delay = 0, $priority = 0)
    {
        if ($job instanceof Closure) {
            $this->queue->insert([$job, $data, $queue, $delay], $priority);
        } else {
            throw new \InvalidArgumentException("Invalid job provided. Expected Closure.");
        }
    }

    public function processJobs()
    {
        while (!$this->queue->isEmpty()) {
            [$job, $data, $queue, $delay] = $this->queue->extract();

            if ($job instanceof Closure) {
                $this->runClosureJob($job, $data, $delay);
            } elseif (is_subclass_of($job, ShouldQueue::class)) {
                $this->dispatchJob($job, $data, $queue, $delay);
            } else {
                throw new \InvalidArgumentException("Invalid job provided. Expected Closure or ShouldQueue.");
            }
        }
    }

    protected function runClosureJob($job, $data, $delay)
    {
        if ($delay > 0) {
            sleep($delay);
        }
        $job($data);
    }

    protected function dispatchJob($job, $data, $queue, $delay)
    {
        $jobInstance = new PendingDispatch($job, $data);
        if ($queue) {
            $jobInstance->onQueue($queue);
        }
        if ($delay > 0) {
            $jobInstance->delay($delay);
        }
        $jobInstance->dispatch();
    }
}

// Lấy danh sách người dùng từ cơ sở dữ liệu
//$users = User::all();
//
//// Khởi tạo QueueJobBuilder
//$queueBuilder = new QueueJobBuilder();
//
//// Thêm công việc gửi email cho từng người dùng
//foreach ($users as $user) {
//    $emailData = [
//        'user_id' => $user->id,
//        'email' => $user->email,
//        'name' => $user->name,
//    ];
//
//    // Thêm công việc gửi email vào QueueJobBuilder
//    $queueBuilder->addJob(function ($data) {
//        $userId = $data['user_id'];
//        $email = $data['email'];
//        $name = $data['name'];
//
//        // Gửi email tới người dùng tại đây
//        Mail::to($email)->send(new YourEmailTemplate($name));
//    }, $emailData, 'emails');
//}
//
//// Xử lý các công việc trong hàng đợi
//$queueBuilder->processJobs();
