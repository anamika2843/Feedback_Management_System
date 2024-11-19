import React from 'react';
import { createTheme } from '@mui/material/styles';

import Button from '@mui/material/Button';

import TextField from '@mui/material/TextField';
import Box from '@mui/material/Box';

import Grid from '@mui/material/Grid';
import axios from 'axios';

function FeedbackLogin({
    feedback,
    type,
    initData,
    handleClose,
    setAuthToken,
    feedback_data,
    guestAllowed,
    successCallback,
    setIsLoading,
}) {
    const theme = createTheme();
    const [email, setEmail] = React.useState('');
    const [name, setName] = React.useState('');
    var lingual_data = initData.lingual_data;
    const saveData = () => {
        setIsLoading(true);

        let formData = new FormData(); //formdata object
        formData.append('anonymous_feedback', true);
        var submit_url;
        if (type == 'suggestion') {
            formData.append('feedback_description', feedback); //append the values with key, value pair
            submit_url = base_url + '/index.php/api/' + board_data.id + '/feedback/save';
        }
        if (type == 'comment') {
            formData.append('description', feedback); //append the values with key, value pair
            submit_url = `${base_url}/index.php/api/${board_data.id}/ideas/${feedback_data.id}/feedback`;
        }

        axios.post(submit_url, formData).then(() => {
            handleClose();
            setIsLoading(false);
            successCallback();
        });
    };

    const saveAllData = () => {
        setIsLoading(true);

        if (email == '') {
            setToastData({ type: 'error', message: lingual_data.email_required });
            return false;
        }

        let formData = new FormData(); //formdata object
        formData.append('user_email', email);
        formData.append('user_name', name);

        var submit_url;
        if (type == 'suggestion') {
            formData.append('feedback_description', feedback); //append the values with key, value pair
            submit_url = base_url + '/index.php/api/' + board_data.id + '/feedback/save';
        }
        if (type == 'comment') {
            formData.append('description', feedback); //append the values with key, value pair
            submit_url = `${base_url}/index.php/api/${board_data.id}/ideas/${feedback_data.id}/feedback`;
        }

        axios.post(submit_url, formData).then((res) => {
            if (res.data.userDetails) {
                localStorage.setItem('authtoken', JSON.stringify(res.data.userDetails));
                setAuthToken(res.data.userDetails['authtoken']);
            }
            successCallback();
            handleClose();
            setIsLoading(false);
        });
    };

    return (
        <>
            <Box textAlign={'center'} p={'5%'}>
                <Box fontSize={'50px'}>😊</Box>
                <Box fontSize={'1.1rem'}>{lingual_data.stay_up_to_date}</Box>
                <Box fontSize={'.85em'}>{lingual_data.we_can_contact_you}</Box>
                <Box mt={'5%'}>
                    <TextField
                        color="info"
                        onChange={(e) => setEmail(e.target.value.trim())}
                        size="small"
                        id="email"
                        label="Email"
                        placeholder="Your Email Address"
                        fullWidth
                    />
                </Box>
                {email !== '' ? (
                    <>
                        <Box mt={'5%'}>
                            <TextField
                                color="info"
                                onChange={(e) => setName(e.target.value.trim())}
                                size="small"
                                id="name"
                                label="Name"
                                placeholder="Your name (Optional)"
                                fullWidth
                            />
                        </Box>
                        <br />
                        <Button
                            style={{ float: 'left' }}
                            onClick={saveAllData}
                            variant="contained"
                            color="info"
                        >
                            {lingual_data.submit}
                        </Button>
                        <br />
                        <br />
                    </>
                ) : (
                    ''
                )}
                {guestAllowed ? (
                    <Button onClick={saveData} style={{ marginTop: '5%' }}>
                        {lingual_data.no_thank_you}
                    </Button>
                ) : (
                    ''
                )}
            </Box>
            <Box textAlign={'center'} px={'20%'}></Box>
        </>
    );
}

export default FeedbackLogin;
