import React from 'react';

import AppBar from '@mui/material/AppBar';
import Toolbar from '@mui/material/Toolbar';
import Avatar from '@mui/material/Avatar';
import Typography from '@mui/material/Typography';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';

import Menu from '@mui/material/Menu';
import MenuItem from '@mui/material/MenuItem';
import CssBaseline from '@mui/material/CssBaseline';

import CookieConsent from 'react-cookie-consent';

import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogContent from '@mui/material/DialogContent';
import DialogTitle from '@mui/material/DialogTitle';

import TextField from '@mui/material/TextField';

import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';
import Snackbar from '@mui/material/Snackbar';
import Alert from '@mui/material/Alert';
import axios, { CancelToken } from 'axios';

import isEmail from 'validator/lib/isEmail';

function Topbar({ initData, authToken, setAuthToken }) {
    const [anchorBoardEl, setAnchorBoardEl] = React.useState(null);
    const [anchorEl, setAnchorEl] = React.useState(null);
    const [loginOpen, setLoginOpen] = React.useState(false);
    const [email, setEmail] = React.useState('');
    const [name, setName] = React.useState('');
    var lingual_data = initData.lingual_data;

    // Privacy
    const [privacyOpen, setPrivacyOpen] = React.useState(false);

    // Terms
    const [termsOpen, setTermsOpen] = React.useState(false);

    //Loading & Toast
    const [isLoading, setIsLoading] = React.useState(false);
    const [toastData, setToastData] = React.useState({});

    const handleBoardMenu = (event) => {
        setAnchorBoardEl(event.currentTarget);
    };

    const closeToastMessage = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }
        setToastData({});
    };

    const handleClose = () => {
        setLoginOpen(false);
        setPrivacyOpen(false);
        setTermsOpen(false);
    };

    const handleBoardMenuClose = () => {
        setAnchorBoardEl(null);
    };

    const handleMenu = (event) => {
        setAnchorEl(event.currentTarget);
    };

    const handleMenuClose = () => {
        setAnchorEl(null);
    };

    const handleLoginSubmit = () => {
        if (email == '') {
            setToastData({ type: 'error', message: lingual_data.email_required });
            return false;
        }
        if (!isEmail(email)) {
            setToastData({ type: 'error', message: lingual_data.email_not_valid });
            return false;
        }

        setIsLoading(true);
        let formData = new FormData(); //formdata object
        formData.append('email', email);
        formData.append('name', name);

        axios.post(base_url + '/index.php/api/users/create', formData).then((res) => {
            localStorage.setItem('authtoken', JSON.stringify(res.data));
            setAuthToken(res.data.authtoken);
            setToastData({ type: 'success', message: lingual_data.logged_in });
            setIsLoading(false);
            handleClose();
        });
    };

    const logout = () => {
        localStorage.removeItem('authtoken');
        setAuthToken(false);
        setAnchorEl(null);
        setToastData({ type: 'success', message: lingual_data.logged_out });
    };

    return (
        <>
            <CssBaseline />
            {/*TOPBAR*/}
            <AppBar
                color="transparent"
                elevation={0}
                variant="outlined"
                position="static"
                sx={{
                    px: { xs: '2%', md: '10%' },
                    py: '0.5%',
                    background: '#fff',
                    border: 'unset',
                    borderBottom: '1px solid rgba(0, 0, 0, 0.12)',
                }}
            >
                <Snackbar
                    open={typeof toastData.type != 'undefined'}
                    autoHideDuration={6000}
                    onClose={closeToastMessage}
                    anchorOrigin={{ vertical: 'top', horizontal: 'right' }}
                >
                    <Alert
                        variant="filled"
                        onClose={closeToastMessage}
                        icon={false}
                        severity={toastData.type ? toastData.type : 'error'}
                        style={{ fontSize: 15 }}
                    >
                        {toastData.message ? toastData.message : ''}
                    </Alert>
                </Snackbar>
                <Toolbar style={{ padding: '0.5%' }} variant="dense">
                    <Avatar
                        sx={{
                            width: { xs: 80, md: 200 },
                            height: { xs: 35, md: 50 },
                            m: { xs: '2%', md: 'inherit' },
                            mr: 2,
                            lineHeight: 'unset',
                        }}
                        alt="F"
                        src={initData.company_logo.company_logo_with_url}
                        onClick={() => {
                            window.location = `${base_url}`;
                            handleBoardMenuClose();
                        }}
                        variant="square"
                        imgProps = {{sx: {height: { xs: "auto", md: "50px" }, width: { xs: "75px", md: "200px" }}}}
                    />
                    <Typography
                        variant="h6"
                        component="div"
                        sx={{ flexGrow: 1, lineHeight: '0px' }}
                    >
                        <Box
                            textAlign={'center'}
                            fontSize={{ xs: '12px', md: 'inherit' }}
                            ml={{ xs: 1, md: 5 }}
                            component="span"
                        >
                            <Box
                                textAlign={'center'}
                                fontSize={{ xs: '12px', md: 'inherit' }}
                                onClick={handleBoardMenu}
                                ml={{ xs: 1, md: 5 }}
                                component="span"
                            >
                                {board_data.board_slug
                                    ? board_data.name.length > 10
                                        ? board_data.name.substring(0, 10) + '...'
                                        : board_data.name
                                    : lingual_data.boards}{' '}
                                <KeyboardArrowDownIcon
                                    style={{ fontSize: 'inherit', verticalAlign: 'middle' }}
                                />
                            </Box>
                            <Menu
                                id="menu-appbar"
                                anchorEl={anchorBoardEl}
                                open={Boolean(anchorBoardEl)}
                                onClose={handleBoardMenuClose}
                            >
                                {initData.boards.length
                                    ? initData.boards.map((board) => {
                                          return (
                                              <MenuItem
                                                  sx={{ padding: { xs: '6px', md: '6px 16px' } }}
                                                  selected={board_data.id == board.id}
                                                  key={board.id}
                                                  onClick={() => {
                                                      window.location = `${base_url}/index.php/front/boards/${board.board_slug}`;
                                                      handleBoardMenuClose();
                                                  }}
                                              >
                                                  {board.name}
                                              </MenuItem>
                                          );
                                      })
                                    : ''}
                            </Menu>
                        </Box>
                        <Box
                            textAlign={'center'}
                            fontSize={{ xs: '12px', md: 'inherit' }}
                            ml={{ xs: 1, md: 5 }}
                            component="span"
                            onClick={() =>
                                (window.location = `${base_url}/index.php/front/${board_data.board_slug}/roadmap`)
                            }
                        >
                            {lingual_data.roadmaps}
                        </Box>
                    </Typography>
                    {authToken ? (
                        <div>
                            <Avatar
                                sx={{
                                    width: { xs: 30, md: 40 },
                                    height: { xs: 30, md: 40 },
                                    mr: 2,
                                    lineHeight: 'unset',
                                }}
                                alt="F"
                                onClick={handleMenu}
                            />
                            <Menu
                                id="menu-appbar"
                                anchorEl={anchorEl}
                                anchorOrigin={{
                                    vertical: 'top',
                                    horizontal: 'right',
                                }}
                                keepMounted
                                transformOrigin={{
                                    vertical: 'top',
                                    horizontal: 'right',
                                }}
                                open={Boolean(anchorEl)}
                                onClose={handleMenuClose}
                            >
                                <MenuItem onClick={logout}>{lingual_data.logout}</MenuItem>
                            </Menu>
                        </div>
                    ) : (
                        <Button
                            sx={{ fontSize: { xs: '12px', md: 'inherit' }, lineHeight: '3px' }}
                            id="topbar_login"
                            onClick={() => setLoginOpen(true)}
                            color="inherit"
                        >
                            {lingual_data.login}
                        </Button>
                    )}
                </Toolbar>
            </AppBar>
            {/*login popup*/}
            <Dialog open={loginOpen} onClose={handleClose} maxWidth={'xs'} fullWidth={true}>
                <DialogContent>
                    <Box textAlign={'center'} fontSize={'50px'}>
                        😊
                    </Box>
                    <Box textAlign="center" px={6} variant="h2" mb={3}>
                        <strong>{lingual_data.login_popup_head}</strong>
                    </Box>
                    <Box textAlign="center" px={3} mb={3}>
                        {lingual_data.login_popup_subhead}
                    </Box>
                    <TextField
                        color="info"
                        onChange={(e) => setEmail(e.target.value.trim())}
                        id="email"
                        label={lingual_data.email_label}
                        placeholder={lingual_data.email_placeholder}
                        fullWidth
                    />
                    {email !== '' ? (
                        <Box mt={'5%'}>
                            <TextField
                                color="info"
                                onChange={(e) => setName(e.target.value.trim())}
                                id="name"
                                label={lingual_data.name_label}
                                placeholder={lingual_data.name_placeholder}
                                fullWidth
                            />
                        </Box>
                    ) : (
                        ''
                    )}
                </DialogContent>
                <DialogActions>
                    <Button onClick={handleClose}>{lingual_data.nevermind}</Button>
                    <Button onClick={handleLoginSubmit} variant="contained" color="info">
                        {lingual_data.submit}
                    </Button>
                </DialogActions>
            </Dialog>
            <Dialog open={privacyOpen} onClose={handleClose} maxWidth={'md'} fullWidth={true}>
                <DialogTitle>{lingual_data.cookie_policy_head}</DialogTitle>
                <DialogContent>
                    <Typography
                        dangerouslySetInnerHTML={{
                            __html: `${initData.cookie_settings.privacy_policy}`,
                        }}
                    ></Typography>
                </DialogContent>
                <DialogActions>
                    <Button onClick={handleClose}>{lingual_data.close}</Button>
                </DialogActions>
            </Dialog>

            <Dialog open={termsOpen} onClose={handleClose} maxWidth={'md'} fullWidth={true}>
                <DialogTitle>{lingual_data.terms_head}</DialogTitle>
                <DialogContent>
                    <Typography
                        dangerouslySetInnerHTML={{
                            __html: `${initData.cookie_settings.terms_usage}`,
                        }}
                    ></Typography>
                </DialogContent>
                <DialogActions>
                    <Button onClick={handleClose}>{lingual_data.close}</Button>
                </DialogActions>
            </Dialog>
            <CookieConsent
                location="bottom"
                buttonText={initData.cookie_settings.cookie_button_text ? initData.cookie_settings.cookie_button_text : 'Ok' }
                cookieName="myAwesomeCookieName2"
                contentClasses="gdpr_content"
                style={{ background: '#fff', fontSize: '14px' }}
                overlayStyle={{ alignSelf: 'center' }}
                buttonStyle={{
                    color: '#f8f8f8',
                    fontSize: '16px',
                    alignSelf: 'center',
                    background: '#03b7f2',
                    padding: '6px 15px',
                }}
                expires={150}
            >
                <strong>
                    <Typography
                        component="span"
                        dangerouslySetInnerHTML={{
                            __html: `${initData.cookie_settings.cookie_notice_text}`,
                        }}
                    ></Typography>
                </strong>{' '}
                <br />
                <Typography
                    component="span"
                    dangerouslySetInnerHTML={{
                        __html: `${initData.cookie_settings.cookie_longtext}`,
                    }}
                ></Typography>
                <Button
                    style={{ padding: 'unset' }}
                    component="a"
                    onClick={() => setTermsOpen(true)}
                >
                    {lingual_data.terms_head}
                </Button>{' '}
                &{' '}
                <Button
                    style={{ padding: 'unset' }}
                    component="a"
                    onClick={() => setPrivacyOpen(true)}
                >
                    {' '}
                    {lingual_data.privacy_policy_head}
                </Button>
            </CookieConsent>
        </>
    );
}

export default Topbar;
