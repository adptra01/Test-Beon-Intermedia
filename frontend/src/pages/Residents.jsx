import React from 'react';
import ResidentsList from '../components/ResidentsList';

const Residents = () => {
  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-4">Residents</h1>
      <ResidentsList />
    </div>
  );
};

export default Residents;
