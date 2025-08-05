import React from 'react';

const NotFoundPage: React.FC = () => {
    return (
        <div className="min-h-screen bg-white flex items-center justify-center px-4">
            <div className="max-w-md w-full text-center">
                {/* Animated 404 Text */}
                <div className="relative mb-8">
                    <h1
                        className="text-9xl font-bold text-transparent bg-clip-text bg-gradient-to-r animate-pulse"
                        style={{
                            backgroundImage: `linear-gradient(45deg, #001E42, #003d84, #001E42)`,
                            WebkitBackgroundClip: 'text',
                            WebkitTextFillColor: 'transparent'
                        }}
                    >
                        404
                    </h1>

                    {/* Floating elements */}
                    <div
                        className="absolute -top-4 -right-4 w-8 h-8 rounded-full animate-bounce"
                        style={{ backgroundColor: '#001E42' }}
                    ></div>
                    <div
                        className="absolute -bottom-2 -left-4 w-6 h-6 rounded-full animate-bounce delay-300"
                        style={{ backgroundColor: '#001E42' }}
                    ></div>
                </div>

                {/* Message */}
                <div className="mb-8">
                    <h2
                        className="text-3xl font-bold mb-4"
                        style={{ color: '#001E42' }}
                    >
                        Oops! Halaman Tidak Ditemukan
                    </h2>
                    <p
                        className="text-lg opacity-80"
                        style={{ color: '#001E42' }}
                    >
                        Halaman yang Anda cari sepertinya sedang bersembunyi atau tidak pernah ada.
                    </p>
                </div>
            </div>
        </div>
    );
};

export default NotFoundPage;