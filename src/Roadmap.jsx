if (module.hot) module.hot.accept();

import React, { useState, useEffect } from 'react';
import { render } from 'react-dom';
import Button from '@mui/material/Button';
import Box from '@mui/material/Box';
import Grid from '@mui/material/Grid';
import Divider from '@mui/material/Divider';
import Chip from '@mui/material/Chip';
import TextField from '@mui/material/TextField';

import KeyboardArrowUpIcon from '@mui/icons-material/KeyboardArrowUp';
import axios, { CancelToken } from 'axios';
import { GoogleReCaptchaProvider } from 'react-google-recaptcha-v3';

import Topbar from './Components/Topbar';
import NoBoards from './Components/NoBoards';
import Typography from '@mui/material/Typography';
import _ from 'underscore';
import Board from 'react-trello';

export function Roadmap() {
    const [initData, setInitData] = React.useState(false);
    const [initRoadmap, setRoadMap] = React.useState([]);
    const [authToken, setAuthToken] = React.useState(
        localStorage.authtoken && JSON.parse(localStorage.authtoken).authtoken != 'null'
            ? JSON.parse(localStorage.authtoken).authtoken
            : false
    );
    const [isLoading, setIsLoading] = React.useState(false);

    useEffect(() => {
        setIsLoading(true);
        axios
            .get(base_url + '/index.php/api/settings')
            .then((res) => {
                return res.data;
            })
            .then((res) => {
                setInitData(res);
                setIsLoading(false);
            });
    }, ['initData']);

    useEffect(() => {
        setIsLoading(true);

        let formData = new FormData(); //formdata object
        formData.append('board_id', board_data.id); //append the values with key, value pair

        axios
            .post(`${base_url}/index.php/api/roadmap/kanban`, formData)
            .then((res) => {
                return res.data;
            })
            .then((res) => {
                setRoadMap(res);
                setIsLoading(false);
            });
    }, ['initRoadmap']);

    const data = {
        lanes: initRoadmap,
    };

    return initData ? (
        board_data.id ? (
            <>
                <Box sx={{ flexGrow: 1 }} bgcolor={'#F9FAFC'} mb={{ md: 5, xs: 0 }}>
                    <Topbar
                        initData={initData}
                        authToken={authToken}
                        setAuthToken={(token) => setAuthToken(token)}
                    />
                </Box>
                <Grid container>
                    <Grid item lg={2} xs={1}></Grid>
                    <Grid item lg={8} xs={10}>
                        <Board
                            laneDraggable={false}
                            cardDraggable={false}
                            data={data}
                            editable={false}
                            hideCardDeleteIcon={true}
                            style={{ background: '#ffffff', justifyContent: "center" }}
                            cardStyle={{ background: '#ffffff' }}
                            laneStyle={{ border: '1px dotted #80808033 !important' }}
                            onCardClick={(feedbackID, data) => {
                                data = JSON.parse(data);
                                window.open(
                                    base_url +
                                        '/index.php/front/' +
                                        data.board_slug +
                                        '/feedback/' +
                                        feedbackID
                                );
                            }}
                        />
                    </Grid>
                    <Grid item lg={2} xs={1}></Grid>
                </Grid>
            </>
        ) : (
            <NoBoards />
        )
    ) : (
        ''
    );
}

render(<Roadmap></Roadmap>, document.querySelector('#root'));
