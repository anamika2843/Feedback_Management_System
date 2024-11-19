<?php

namespace App\Controllers;

class Front extends App_Controller
{
    protected $custom_model;

    public function __construct()
    {
        $this->custom_model = Model('App\Models\Custom_model');
    }

    public function index()
    {
        $board = $this->custom_model->getSingleRow('board');
        if (!empty($board)) {
            return redirect()->to('front/boards/'.$board->board_slug);
        }

        return view('front');
    }

    public function boards($slug = '')
    {
        if (empty($slug)) {
            $board = $this->custom_model->getSingleRow('board');
            if (!empty($board)) {
                return redirect()->to('front/boards/'.$board->board_slug);
            }
        }
        $data['board_data'] = $this->custom_model->getSingleRow('board', ['board_slug' => $slug]);
        if (empty($data['board_data'])) {
            $board = $this->custom_model->getSingleRow('board');
            if (!empty($board)) {
                return redirect()->to('front/boards/'.$board->board_slug);
            }
        }
        if (!empty($data['board_data']->id)) {
            $data['categories'] = $this->custom_model->getCategoryRowsWithCount($data['board_data']->id);
        }

        return view('front', $data);
    }

    public function roadmap($slug)
    {
        $data['board_data'] = $this->custom_model->getSingleRow('board', ['board_slug' => $slug]);

        return view('front_roadmap', $data);
    }

    public function feedback($slug, $feedback_id)
    {
        if (empty($slug) || empty($feedback_id)) {
            $board = $this->custom_model->getSingleRow('board');
            if (!empty($board)) {
                return redirect()->to('front/boards/'.$board->board_slug);
            }
        }
        $data['board_data'] = $this->custom_model->getSingleRow('board', ['board_slug' => $slug]);
        if (empty($data['board_data'])) {
            $board = $this->custom_model->getSingleRow('board');
            if (!empty($board)) {
                return redirect()->to('front/boards/'.$board->board_slug);
            }
        }
        if (!empty($feedback_id) && !empty($data['board_data']->id)) {
            $data['feedback_data'] = $feedback_data = $this->custom_model->getSingleRow('feedbacks', ['id' => $feedback_id, 'board_id' => $data['board_data']->id]);
            if (empty($feedback_data)) {
                return redirect()->to('front/boards/'.$data['board_data']->board_slug);
            }
        }

        return view('front_single_feedback', $data);
    }
}
