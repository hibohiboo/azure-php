import { db, serverTimestamp, toSerializeObject } from '@/domain/firebase';
import { Room } from '../types';

export const create = async (item: Room, uid: string) => {
  const list = db.collection('online-tool-rooms');

  const { id } = await list.doc();
  await Promise.all([
    list.doc(id).set({
      ...item,
      uid,
      createdAt: serverTimestamp(),
    }),
  ]);
  const newRef = await list.doc(id).get();
  const newItem = newRef.data();
  if (!newItem) throw new Error('create failed newItem is empty');
  return { ...newItem, id, createdAt: toSerializeObject(newItem.createdAt) };
};
