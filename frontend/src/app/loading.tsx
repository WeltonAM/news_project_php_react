'use client';

import React, { useState, useEffect } from "react";

export default function App() {
    const colors = [
        "text-blue-500",
        "text-green-500",
        "text-yellow-500",
        "text-red-500",
    ];
    const [currentColor, setCurrentColor] = useState(colors[0]);
    const [currentIndex, setCurrentIndex] = useState(0);

    useEffect(() => {
        const interval = setInterval(() => {
            setCurrentIndex((prevIndex) => (prevIndex + 1) % colors.length);
        }, 1000);

        return () => clearInterval(interval);
    }, [colors.length]);

    useEffect(() => {
        setCurrentColor(colors[currentIndex]);
    }, [currentIndex, colors]);

    return (
        <div className="flex justify-center items-center h-screen">
            <div className={`animate-spin rounded-full h-16 w-16 border-t-4 ${currentColor}`} />
        </div>
    );
}