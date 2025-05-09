import React from "react";

export default function LayoutLogin({ children }) {
  return (
    <div className="min-h-full flex flex-col justify-center bg-gray-50 py-12 sm:px-6 lg:px-8">
      {children}
    </div>
  );
}
